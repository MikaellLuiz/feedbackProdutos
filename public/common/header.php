<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Feedback de Produtos - Casas Luiza</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        
        body {
            background-color: #f4f4f4;
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .header {
            background-color: #0033B8;
            color: white;
            padding: 10px 0;
            display: flex;
            align-items: center;
        }
        
        .header-container {
            width: 90%;
            margin: 0 auto;
            max-width: 1200px;
        }
        
        .logo-container {
            padding: 10px 0;
        }
        
        .logo {
            max-height: 40px;
        }
        
        .container {
            width: 90%;
            margin: 20px auto;
            background-color: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 5px;
            flex: 1;
            max-width: 1200px;
        }
        
        .navbar {
            background-color: #002796;
            overflow: hidden;
        }
        
        .navbar-container {
            width: 90%;
            margin: 0 auto;
            max-width: 1200px;
        }
        
        .navbar a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }
        
        .navbar a:hover {
            background-color: #003DE6;
        }
        
        h1, h2 {
            color: #0033B8;
            margin-bottom: 20px;
        }
        
        .product-card {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
        }
        
        .product-img {
            max-width: 100px;
            height: auto;
            display: block;
            margin-bottom: 10px;
        }
        
        .feedback-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            background-color: #fff;
        }
        
        .star-rating {
            color: gold;
            font-size: 1.2em;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-align: center;
        }
        
        .btn-primary {
            background-color: #0033B8;
            color: white;
        }
        
        .btn-primary:hover {
            background-color: #002796;
        }
        
        .page-title {
            color: #0099E0;
            font-size: 28px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-container">
            <div class="logo-container">
                <img src="/feedbackProdutos/public/img/logo.png" alt="Casas Luiza" class="logo">
            </div>
        </div>
    </div>
    <div class="navbar">
        <div class="navbar-container">
            <a href="index.php?rota=usuario/listar">Usuários</a>
            <a href="index.php?rota=produto/listar">Produtos</a>
            <a href="index.php?rota=feedback/listar">Feedbacks</a>
        </div>
    </div>
    <div class="container">
</body>
</html>