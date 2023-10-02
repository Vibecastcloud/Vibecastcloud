<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="assets/images/icone.png">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Vibecast Lives</title>
    <style>
        /* Estilos gerais */
        body, h1, h2, h3, p, a {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #1D1D1B; /* Cor de fundo atualizada */
            color: #fff;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Estilos do cabeçalho */
        header {
            background-color: #005979; /* Cor do cabeçalho atualizada */
            color: #fff;
            text-align: center;
            padding: 20px 0;
        }

        /* Estilos do conteúdo principal */
        main {
            padding: 20px 0;
        }

        .eventos-galeria {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            margin: -10px;
        }

        .evento {
            flex: 0 0 calc(33.33% - 20px);
            margin: 10px;
            padding: 20px;
            background-color: #306980; /* Cor de fundo dos eventos atualizada */
            border: 1px solid #444;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .evento img {
            max-width: 100px;
            margin-bottom: 10px;
        }

        .botao-assistir {
            display: inline-block;
            padding: 8px 16px;
            background-color: #647A84; /* Cor do botão atualizada */
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .botao-assistir:hover {
            background-color: #007542;
        }

        /* Estilos do rodapé */
        footer {
            text-align: center;
            padding: 20px 0;
            background-color: #222;
        }
    </style>
</head>
<body>
    <!-- Conteúdo da página inicial -->
    <header>
        <h1>El Shaddai TV - Eventos en Vivo</h1>
        <a href="admin/login.php" class="botao-assistir">
            <i class="fas fa-lock"></i> Login de Administrador
        </a>
    </header>

    <main>
        <h2>Transmissões ao Vivo</h2>

        <div class="eventos-galeria">
            <?php
            // Incluir o arquivo de conexão com o banco de dados
            include_once 'includes/db.php';

            if (!$conn) {
                die("Erro na conexão com o banco de dados: " . mysqli_connect_error());
            }

            // Consulta SQL para selecionar todas as transmissões cadastradas
            $query = "SELECT * FROM transmissoes";
            $result = $conn->query($query);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $data_transmissao = date('d/m/Y H:i', strtotime($row['data']));
                    $descricao = isset($row['descricao']) ? $row['descricao'] : "Descrição não disponível";
            ?>
                    <div class="evento">
                        <img src="image/<?php echo $row['imagem']; ?>" alt="Imagem da transmissão">
                        <h3><?php echo $row['titulo']; ?></h3>
                        <p>Data de Início: <?php echo $data_transmissao; ?></p>
                        <p><?php echo $descricao; ?></p>
                        <?php if ($row['tipo'] == 'livre'): ?>
                            <a href="user/assistir_live.php?id=<?php echo $row['id']; ?>" class="botao-assistir">Assistir Live</a>
                        <?php elseif ($row['tipo'] == 'pago'): ?>
                            <a href="user/assistir_pago.php?id=<?php echo $row['id']; ?>" class="botao-assistir">Assistir Pago</a>
                        <?php endif; ?>
                    </div>
            <?php
                }
            } else {
                echo "<p>Nenhuma transmissão cadastrada no momento.</p>";
            }
            ?>
        </div>
    </main>

    <!-- Carregar a página de loading apenas uma vez -->
    <script>
        if (!sessionStorage.getItem('loaded')) {
            sessionStorage.setItem('loaded', 'true');
            window.location.href = 'loading.html';
        }
    </script>

    <!-- Carregar a página de loading novamente ao atualizar a página -->
    <script>
        window.addEventListener('beforeunload', function() {
            sessionStorage.removeItem('loaded');
        });
    </script>
</body>
</html>
