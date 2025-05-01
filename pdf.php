<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>PDF в JPG</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
  <style>
    body { font-family: sans-serif; padding: 20px; max-width: 800px; margin: 0 auto; }
    #result { margin-top: 10px; }
    img { max-width: 100%; border: 1px solid #ddd; cursor: pointer; }
    .download { display: inline-block; margin-top: 10px; padding: 8px 15px; 
                background: #4CAF50; color: white; text-decoration: none; }
    .fullscreen { position: fixed; top: 0; left: 0; width: 100%; height: 100%; 
                 background: rgba(0,0,0,0.9); display: flex; align-items: center; 
                 justify-content: center; z-index: 1000; cursor: zoom-out; }
    .fullscreen img { max-width: 90%; max-height: 90%; border: 2px solid white; }
  </style>
</head>
<body>
  <h2>PDF в JPG</h2>
  <input type="file" id="pdfInput" accept="application/pdf">
  <div id="result"></div>

  <script>
    const findEdges = (canvas, margin = 10) => {
      const ctx = canvas.getContext('2d');
      const { width, height } = canvas;
      const imgData = ctx.getImageData(0, 0, width, height).data;
      const isDark = (x, y) => (imgData[(y*width+x)*4] + imgData[(y*width+x)*4+1] + imgData[(y*width+x)*4+2]) < 450;

      const scan = (start, end, step, axis) => {
        for (let i = start; step > 0 ? i < end : i >= end; i += step) {
          for (let j = 0; j < (axis === 'x' ? height : width); j++) {
            if (isDark(axis === 'x' ? i : j, axis === 'x' ? j : i)) {
              return i + (step > 0 ? -margin : margin);
            }
          }
        }
        return axis === 'x' ? 0 : start;
      };

      return {
        left: scan(0, width, 1, 'x'),
        right: scan(width-1, 0, -1, 'x'),
        top: scan(0, height, 1, 'y'),
        bottom: scan(height-1, 0, -1, 'y')
      };
    };

    const showFullscreen = (src) => {
      const overlay = document.createElement('div');
      overlay.className = 'fullscreen';
      overlay.innerHTML = `<img src="${src}" onclick="event.stopPropagation()">`;
      overlay.onclick = () => document.body.removeChild(overlay);
      document.body.appendChild(overlay);
    };

    document.getElementById('pdfInput').addEventListener('change', async (e) => {
      if (!e.target.files[0]) return;

      try {
        // PDF
        const pdf = await pdfjsLib.getDocument({ data: await e.target.files[0].arrayBuffer() }).promise;
        const canvas = document.createElement('canvas');
        const viewport = (await pdf.getPage(1)).getViewport({ scale: 3 });
        Object.assign(canvas, { width: viewport.width, height: viewport.height });
        await (await pdf.getPage(1)).render({ canvasContext: canvas.getContext('2d'), viewport }).promise;

        // Обрезка
        const { left, right, top, bottom } = findEdges(canvas);
        const cropped = Object.assign(document.createElement('canvas'), { 
          width: right - left, height: bottom - top 
        });
        cropped.getContext('2d').drawImage(canvas, left, top, right-left, bottom-top, 0, 0, right-left, bottom-top);

        // Вывод
        const img = new Image();
        img.src = cropped.toDataURL('image/jpeg');
        img.onclick = () => showFullscreen(img.src);
        
        const link = `<a href="${img.src}" download="${e.target.files[0].name.replace('.pdf','.jpg')}" 
                     class="download">📥 Скачать JPG</a>`;
        document.getElementById('result').innerHTML = `${link}<br>`;
        document.getElementById('result').appendChild(img);

      } catch (error) {
        console.error('Ошибка:', error);
        document.getElementById('result').innerHTML = '<p style="color:red">Ошибка обработки файла</p>';
      }
    });
  </script>
</body>
</html>
