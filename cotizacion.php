<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <!-- Modal -->
  <div class="modal" id="modalFormulario">
    <div class="modal-content">
      <span class="close-btn" onclick="closeModal()">&times;</span>

      <h2>TRADUCCIONES</h2>
      <p><strong>&gt;Por página</strong></p>

      <label for="observaciones">Observaciones:</label>
      <textarea id="observaciones" placeholder="Escribe tus observaciones aquí..."></textarea>

      <label>Adjuntar documentos:</label>
      <div class="file-section">
        <label>
          <input type="file" id="file1" hidden>
          <img src="https://img.icons8.com/ios-filled/50/000000/document.png" alt="Documento" onclick="document.getElementById('file1').click();">
        </label>
        <label>
          <input type="file" id="file2" hidden>
          <img src="https://img.icons8.com/ios-filled/50/000000/folder-invoices--v1.png" alt="Carpeta" onclick="document.getElementById('file2').click();">
        </label>
      </div>

      <textarea placeholder="Detalles adicionales..."></textarea>

      <div class="checkbox-section">
        <input type="checkbox" id="terminos">
        <label for="terminos">Acepto Términos y condiciones</label>
      </div>

      <button class="submit-btn" onclick="enviarFormulario()">Enviar Solicitud De Cotización</button>
    </div>
  </div>

</body>
</html>