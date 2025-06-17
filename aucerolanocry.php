<?php 
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
        'pink'    => "\033[1;95m",
    ];
    return $colors[$color] . $string . $colors['reset'];
}

function android_tools_instalado() {
    $output = [];
    exec("which adb", $output);
    return !empty($output) && strpos($output[0], "/") !== false;
}

function instalar_android_tools() {
    echo color("\n[!] Instalando android-tools...\n", "purple");
    system("pkg install android-tools -y");
}

function verificar_conexao_adb() {
    $output = [];
    exec("adb devices", $output);
    foreach ($output as $linha) {
        if (preg_match('/localhost:\\d+\s+device/', $linha)) {
            return true;
        }
    }
    return false;
}

function parear_adb() {
    echo color("\n[!] ADB não está conectado.\n\n", "red");
    echo color("[*] PARA PAREAR, SIGA AS INSTRUÇÕES ABAIXO:\n", "blue");
    echo color("Digite o CÓDIGO DE PAREAMENTO e a PORTA separados por espaço\n", "green");
    echo color("Exemplo: 123456 4343\n", "yellow");
    echo color("COLOQUE O CÓDIGO DE PAREAMENTO, UM ESPAÇO E DEPOIS A PORTA: ", "green");
    $linha = trim(fgets(STDIN));
    list($codigo, $porta) = explode(' ', $linha);
    system("adb pair localhost:$porta $codigo > /dev/null 2>&1");
    echo color("\nAgora digite a porta para conectar via ADB (exemplo: 4343): ", "yellow");
    $porta_con = trim(fgets(STDIN));
    system("adb connect localhost:$porta_con > /dev/null 2>&1");
    if (verificar_conexao_adb()) {
        echo color("\n[$] ADB pareado e conectado com sucesso! [APROVADO]\n", "purple");
    } else {
        echo color("\n[!] Falha ao conectar ao ADB. Verifique a porta e tente novamente.\n", "red");
        exit;
    }
}

function executar_script_baypass() {
    $script = "/data/data/com.termux/files/home/copiar_via_adb.sh";
    if (!file_exists($script)) {
        echo color("\n[!] Script copiar_via_adb.sh não encontrado em \$HOME!\n", "red");
        echo color("[!] Mova o script para \$HOME ou corrija o caminho no menu.", "yellow");
        exit;
    }
    echo color("\n[*] Executando script de bypass completo...\n", "cyan");
    system("bash \$script");
}

system("clear");

echo color("   ___                 _           _           ____                       \n", "cyan");
echo color("  / _ \\  ___  ___ _ __(_) ___  ___| |_ ___    | __ )  __ _ _ __ ___  ___ \n", "cyan");
echo color(" | | | |/ _ \\/ __| '__| |/ _ \\/ __| __/ __|   |  _ \\ / _` | '__/ _ \\/ __|\n", "cyan");
echo color(" | |_| |  __/ (__| |  | |  __/ (__| |_\\__ \\   | |_) | (_| | | |  __/\\__ \\ \n", "cyan");
echo color("  \\\___/ \\\___|\\___|_|  |_|\\___|\\___|\\__|___/   |____/ \\\__,_|_|  \\\___||___/\n", "cyan");
echo "\n";
echo color("          ===  AUCEROLA BAYPASS MENU  ===\n\n", "yellow");

echo color("[0] Instalar Módulos e Parear ADB\n", "purple");
echo color("[1] Baypass Free Fire Normal (Atualizar conexão)\n", "green");
echo color("[2] Baypass Free Fire Max\n", "green");
echo color("[3] Sair\n\n", "red");
echo color("[#] Escolha uma das opções acima: ", "blue");

$opcao = trim(fgets(STDIN));

switch ($opcao) {
    case '0':
        if (!android_tools_instalado()) {
            echo color("\n[!] android-tools não está instalado.\n", "red");
            instalar_android_tools();
        } else {
            echo color("\n[$] android-tools já está instalado.\n\n", "purple");
        }
        if (!verificar_conexao_adb()) {
            parear_adb();
        } else {
            echo color("\n[$] ADB já está conectado.\n\n", "purple");
        }
        break;
    case '1':
        if (!android_tools_instalado()) {
            echo color("\n[!] android-tools não está instalado.\n", "red");
            instalar_android_tools();
        } else {
            echo color("\n[$] android-tools já está instalado.\n\n", "purple");
        }
        if (!verificar_conexao_adb()) {
            parear_adb();
        } else {
            echo color("\n[$] ADB já está conectado.\n\n", "purple");
        }
        executar_script_baypass();
        echo color("\n[★] Opção 1 executada com sucesso!\n", "cyan");
        break;
    case '2':
        echo color("\n[!] Opção 2 ainda não implementada.\n", "red");
        break;
    case '3':
        echo color("\n[!] Saindo...\n", "red");
        exit;
        break;
    default:
        echo color("\n[!] Opção inválida!\n", "red");
        break;
}
?>
