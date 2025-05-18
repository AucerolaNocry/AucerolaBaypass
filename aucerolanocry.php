<?php
function color($string, $color) {
    $colors = [
        'reset'   => "\033[0m",
        'red'     => "\033[1;31m",
        'green'   => "\033[1;32m",
        'yellow'  => "\033[1;33m",
        'blue'    => "\033[1;34m",
        'purple'  => "\033[1;35m",
        'cyan'    => "\033[1;36m",
        'white'   => "\033[1;37m",
    ];
    return $colors[$color] . $string . $colors['reset'];
}

system("clear");

// Caveira em vermelho
echo color("
███████████████████████████
███████▀▀▀░░░░░░░▀▀▀███████
████▀░░░░░░░░░░░░░░░░░▀████
███│░░░░░░░░░░░░░░░░░░░│███
██▌│░░░░░░░░░░░░░░░░░░░│▐██
██░└┐░░░░░░░░░░░░░░░░░┌┘░██
██░░└┐░░░░░░░░░░░░░░┌┘░░██
██░░┌┘▄▄▄▄▄░░░░░▄▄▄▄▄└┐░░██
██▌░│██████▌░░░▐██████│░▐██
███░│▐███▀▀░░▄░░▀▀███▌│░███
██▀─┘░░░░░░░▐█▌░░░░░░░└─▀██
██▄░░░▄▄▄▓░░▀█▀░░▓▄▄▄░░░▄██
████▄─┘██▌░░░░░░░▐██└─▄████
█████░░▐█─┬┬┬┬┬┬┬─█▌░░█████
████▌░░░▀┬┼┼┼┼┼┼┼┬▀░░░▐████
█████▄░░░└┴┴┴┴┴┴┴┘░░░▄█████
███████▄░░░░░░░░░░░▄███████
██████████▄▄▄▄▄▄▄██████████
███████████████████████████
", "red");

echo color("        ==  AUCEROLA BAYPASS MENU  ==\n", "yellow");
echo color("             by @AucerolaNocry\n\n", "purple");

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
