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
        if (preg_match('/localhost:\d+\s+device/', $linha)) {
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
    echo color("\n[*] Executando função de bypass direta...\n", "cyan");

    $ORIG = "/storage/emulated/0/Pictures/100PINT/PINS/AUCEROLABAY/com.dts.freefireth";
    $DEST = "/storage/emulated/0/Android/data/com.dts.freefireth";
    $data = "20250528";

    system("adb shell '[ -d "$ORIG" ]'", $origem_status);
    if ($origem_status !== 0) {
        echo color("❌ Erro: pasta limpa não encontrada.\n", "red");
        exit(1);
    } else {
        echo color("✅ Pasta limpa encontrada.\n", "green");
    }

    if (0 === system("adb shell cp -rf '$ORIG/'* '$DEST/' 2>/dev/null")) {
        echo color("✅ Pasta limpa aplicada.\n", "green");
    } else {
        echo color("❌ Erro ao copiar a pasta limpa.\n", "red");
        exit(1);
    }

    if (0 === system("adb shell monkey -p com.dts.freefireth -c android.intent.category.LAUNCHER 1 >/dev/null 2>&1")) {
        echo color("✅ Free Fire aberto.\n", "green");
    } else {
        echo color("❌ Erro ao abrir Free Fire.\n", "red");
    }

    $ajustou = true;
    $linhas = [
        "$DEST/files/ShaderStripSettings {$data}0930.00",
        "$DEST/files {$data}0945.00",
        "$DEST/files/contentcache {$data}1005.00",
        "$DEST/files/contentcache/optional {$data}1015.00",
        "$DEST/files/contentcache/optional/android {$data}1025.00",
        "$DEST/files/contentcache/optional/android/gameassetbundles {$data}1035.00",
        "$DEST/files/contentcache/optional/android/optionalavatarres {$data}1040.00",
        "$DEST {$data}1045.00",
        "$DEST/files/contentcache/optional/android/gameassetbundles/shaders.t4NwpizuffoEtxXrXzvYaKh4HQ8~3D {$data}1055.00",
    ];

    foreach ($linhas as $linha) {
        [$caminho, $horario] = explode(' ', $linha);
        system("adb shell '[ -e "$caminho" ]'", $existe);
        if ($existe === 0) {
            system("adb shell touch -t $horario '$caminho'");
        } else {
            $ajustou = false;
            echo color("❌ Caminho não encontrado: $caminho\n", "red");
        }
    }

    if ($ajustou) {
        echo color("✅ Datas ajustadas com sucesso.\n", "green");
    } else {
        echo color("⚠️ Algumas datas não puderam ser ajustadas.\n", "yellow");
    }

    sleep(6);

    if (0 === system("adb shell monkey -p com.discord -c android.intent.category.LAUNCHER 1 >/dev/null 2>&1")) {
        echo color("✅ Discord aberto.\n", "green");
    } else {
        echo color("❌ Erro ao abrir o Discord.\n", "red");
    }

    system("adb shell am start -a android.settings.USAGE_ACCESS_SETTINGS > /dev/null 2>&1");
    sleep(2);

    if (0 === system("adb shell am force-stop me.piebridge.brevent > /dev/null 2>&1")) {
        echo color("✅ Brevent finalizado.\n", "green");
    } else {
        echo color("❌ Erro ao finalizar Brevent.\n", "red");
    }
}

system("clear");

echo color("   ___                 _           _           ____                       \n", "cyan");
echo color("  / _ \\  ___  ___ _ __(_) ___  ___| |_ ___    | __ )  __ _ _ __ ___  ___ \n", "cyan");
echo color(" | | | |/ _ \\/ __| '__| |/ _ \\/ __| __/ __|   |  _ \\ / _` | '__/ _ \\/ __|\n", "cyan");
echo color(" | |_| |  __/ (__| |  | |  __/ (__| |_\\__ \\   | |_) | (_| | | |  __/\\__ \\ \n", "cyan");
echo color("  \\___/ \\___|\\___|_|  |_|\\___|\\___|\\__|___/   |____/ \\__,_|_|  \\___||___/\n", "cyan");
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
