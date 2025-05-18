<?php
// Função para adicionar cor ANSI ao terminal
function color($string, $color) {
    $colors = [
        'reset'   => "\033[0m",
        'green'   => "\033[1;32m",
        'yellow'  => "\033[1;33m",
        'cyan'    => "\033[1;36m",
        'red'     => "\033[1;31m",
        'blue'    => "\033[1;34m",
        'purple'  => "\033[1;35m",
        'white'   => "\033[1;37m",
    ];
    return $colors[$color] . $string . $colors['reset'];
}

// Limpa a tela
system("clear");

// Banner personalizado em ASCII
echo color("   ___                 _           _           ____                       \n", "cyan");
echo color("  / _ \\  ___  ___ _ __(_) ___  ___| |_ ___    | __ )  __ _ _ __ ___  ___ \n", "cyan");
echo color(" | | | |/ _ \\/ __| '__| |/ _ \\/ __| __/ __|   |  _ \\ / _` | '__/ _ \\/ __|\n", "cyan");
echo color(" | |_| |  __/ (__| |  | |  __/ (__| |_\\__ \\   | |_) | (_| | | |  __/\\__ \\\n", "cyan");
echo color("  \\___/ \\___|\\___|_|  |_|\\___|\\___|\\__|___/   |____/ \\__,_|_|  \\___||___/\n", "cyan");
echo "\n";
echo color("          ===  AUCEROLA BAYPASS MENU  ===\n\n", "yellow");

// Exibe o menu com cores
echo color("[0] ", "yellow") . color("Instalar Módulos", "white") . color(" (Atualizar e instalar módulos)\n", "purple");
echo color("[1] ", "yellow") . color("Baypass Free Fire Normal\n", "green");
echo color("[2] ", "yellow") . color("Baypass Free Fire Max\n", "green");
echo color("[S] ", "yellow") . color("Sair\n\n", "red");
echo color("[#] Escolha uma das opções acima: ", "blue");

// Lê a opção do usuário
$opcao = trim(fgets(STDIN));

// Switch de opções
switch ($opcao) {
    case '0':
        echo color("\n[!] Instalando módulos...\n", "purple");
        // Adicione aqui comandos de instalação, se desejar
        break;
    case '1':
        echo color("\n[+] Executando Baypass Free Fire Normal...\n", "green");
        // Lógica para Free Fire Normal aqui
        break;
    case '2':
        echo color("\n[+] Executando Baypass Free Fire Max...\n", "green");
        // Lógica para Free Fire Max aqui
        break;
    case 'S':
    case 's':
        echo color("\n[!] Saindo...\n", "red");
        exit;
        break;
    default:
        echo color("\n[!] Opção inválida!\n", "red");
        break;
}
?>
