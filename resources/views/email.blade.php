<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<style>
    body { font-family: Arial, sans-serif; color: #333; }
    .container { width: 100%; max-width: 600px; margin: auto; padding: 20px; border-radius: 8px; border: 1px solid #ddd; }
    .titulo { font-size: 20px; font-weight: bold; color: #004a8f; }
    .footer { font-size: 13px; margin-top: 20px; color: #555; }
    .info p { margin: 4px 0; }
</style>
</head>
<body>
<div class="container">
    <p class="titulo">Confirmação de Inscrição – CICTED</p>
    <p>Prezado(a)s <strong>{{ $categoria }}(es)</strong>,</p>

    <p>A Secretaria do <strong>Congresso Internacional de Ciência, Tecnologia e Desenvolvimento (CICTED)</strong>, da <strong>Universidade Rovuma</strong>, confirma a validação da sua inscrição.</p>

    <div class="info">
        <p><strong>Informações do Participante:</strong></p>
        <p>📌 <strong>Nome:</strong> {{ $nome }}</p>
    </div>

    <p><strong>Próximos Passos:</strong></p>
    <ul>
        <li>Programação oficial</li>
        <li>Informações aos participantes</li>
        <li>Certificados e submissão de trabalhos (se aplicável)</li>
    </ul>

    <p>📍 <strong>Local:</strong> Universidade Rovuma</p>
    <p>📅 <strong>Data:</strong> 16 e 17 de Setembro de 2026</p>

    <p>Obrigado pela sua participação.</p>

    <p class="footer">
        Comissão Organizadora – CICTED<br>
        Universidade Rovuma
    </p>
</div>
</body>
</html>
