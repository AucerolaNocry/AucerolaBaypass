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
    system("pkg install android-tools -y > /dev/null 2>&1");
}

function verificar_conexao_adb() {
    $output = [];
    exec("adb devices", $output);
    foreach ($output as $linha) {
        if (preg_match('/localhost:\\d+\s+device/', $linha) || preg_match('/device\s+$/', $linha)) {
            return true;
        }
    }
    return false;
}

function detectar_codigo_pareamento() {
    echo color("\n[!] Tentando detectar automaticamente o código de pareamento...\n", "yellow");
    system("adb shell uiautomator dump /sdcard/ui.xml > /dev/null 2>&1");
    system("adb pull /sdcard/ui.xml ./ui.xml > /dev/null 2>&1");
    if (!file_exists("ui.xml")) {
        echo color("[X] Falha ao capturar tela.\n", "red");
        return [null, null];
    }
    $xml = file_get_contents("ui.xml");
    if (preg_match('/(\\d{6}).*?(\\d{4})/', $xml, $m)) {
        return [$m[1], $m[2]];
    }
    echo color("[X] Não foi possível detectar o código de pareamento.\n", "red");
    return [null, null];
}

function parear_adb() {
    echo color("\n[!] ADB não está conectado.\n\n", "red");
    echo color("[*] TENTANDO PAREAR AUTOMATICAMENTE...\n", "blue");
    list($codigo, $porta) = detectar_codigo_pareamento();

    if ($codigo && $porta) {
        echo color("\n[Código] ➤ $codigo\n", "green");
        echo color("[Porta]  ➤ $porta\n", "green");
        system("adb pair localhost:$porta $codigo > /dev/null 2>&1");
        system("adb connect localhost:$porta > /dev/null 2>&1");
    } else {
        echo color("\n[!] Insira manualmente o CÓDIGO DE PAREAMENTO e a PORTA (ex: 123456 4343): ", "yellow");
        $linha = trim(fgets(STDIN));
        list($codigo, $porta) = explode(' ', $linha);
        system("adb pair localhost:$porta $codigo > /dev/null 2>&1");
        echo color("Digite a porta para conectar via ADB (exemplo: 4343): ", "yellow");
        $porta = trim(fgets(STDIN));
        system("adb connect localhost:$porta > /dev/null 2>&1");
    }

    if (verificar_conexao_adb()) {
        echo color("\n[$] ADB pareado e conectado com sucesso! [APROVADO]\n", "purple");
    } else {
        echo color("\n[!] Falha ao conectar ao ADB. Verifique a porta e tente novamente.\n", "red");
        exit;
    }
}

// (restante do script continua igual)
?>
