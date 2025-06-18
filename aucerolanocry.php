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

system("clear");

echo color("   ___                 _           _           ____                       \n", "cyan");
echo color("  / _ \\  ___  ___ _ __(_) ___  ___| |_ ___    | __ )  __ _ _ __ ___  ___ \n", "cyan");
echo color(" | | | |/ _ \\/ __| '__| |/ _ \\/ __| __/ __|   |  _ \\/ _` | '__/ _ \\/ __|\n", "cyan");
echo color(" | |_| |  __/ (__| |  | |  __/ (__| |_\\__ \\   | |_) | (_| | | |  __/\\__ \\ \n", "cyan");
echo color("  \\\___/ \\\___|\\___|_|  |_|\\___|\\___|\\__|___/   |____/ \\\__,_|_|  \\\___||___/\n", "cyan");
echo "\n";
echo color("          ===  AUCEROLA BAYPASS MENU  ===\n\n", "yellow");

echo color("[0] Instalar Módulos e Parear ADB\n", "purple");
echo color("[1] Bypass Free Fire com Ajuste de Data e Log\n", "green");
echo color("[2] Sair\n\n", "red");
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
        if (!android_tools_instalado()) instalar_android_tools();
        if (!verificar_conexao_adb()) parear_adb();

        echo color("\n[*] Pressione ENTER para iniciar o bypass...\n", "cyan");
        fgets(STDIN);

        $orig = "/storage/emulated/0/Pictures/100PINT/PINS/AUCEROLABAY/com.dts.freefireth";
        $dest = "/storage/emulated/0/Android/data/com.dts.freefireth";
        $data = "20250528";

        echo "✅ Pasta limpa encontrada.\n";

        // Fecha configurações antes de abrir Data e Hora
        system("adb shell 'am force-stop com.android.settings' > /dev/null 2>&1");
        sleep(1);
        system("adb shell 'am start -a android.settings.DATE_SETTINGS' > /dev/null 2>&1");
        echo "⏳ Abrindo configurações de Data e Hora...\n";
        echo "🕐 Ajuste a data/hora e pressione ENTER para continuar.\n";
        fgets(STDIN);

        // Verifica se fuso horário automático está ativado
        $auto_time = trim(shell_exec("adb shell settings get global auto_time"));
        $auto_tz = trim(shell_exec("adb shell settings get global auto_time_zone"));

        if ($auto_time !== "1") {
            echo color("⚠️ Atenção: A data/hora automática está DESATIVADA! Ative para evitar W.O\n", "yellow");
        } else {
            echo color("✅ Data/hora automática está ativada.\n", "green");
        }

        if ($auto_tz !== "1") {
            echo color("⚠️ Atenção: O fuso horário automático está DESATIVADO! Ative para evitar W.O\n", "yellow");
        } else {
            echo color("✅ Fuso horário automático está ativado.\n", "green");
        }

        echo "📦 Aplicando pasta limpa no destino...\n";
        system("adb shell 'cp -rf $orig/* $dest/' > /dev/null 2>&1");
        echo "✅ Pasta limpa aplicada.
";
        echo "🚀 Abrindo Free Fire...
";
        system("adb shell monkey -p com.dts.freefireth -c android.intent.category.LAUNCHER 1 > /dev/null 2>&1");
        sleep(5);

        // Abre Free Fire após aplicar a pasta limpa
        

        $caminhos = [
            "$dest/files/ShaderStripSettings" => "${data}0930.00",
            "$dest/files" => "${data}0945.00",
            "$dest/files/contentcache" => "${data}1005.00",
            "$dest/files/contentcache/optional" => "${data}1015.00",
            "$dest/files/contentcache/optional/android" => "${data}1025.00",
            "$dest/files/contentcache/optional/android/gameassetbundles" => "${data}1035.00",
            "$dest/files/contentcache/optional/android/optionalavatarres" => "${data}1040.00",
            "$dest" => "${data}1045.00",
            "$dest/files/contentcache/optional/android/gameassetbundles/shaders.t4NwpizuffoEtxXrXzvYaKh4HQ8~3D" => "${data}1055.00",
        ];

        foreach ($caminhos as $caminho => $timestamp) {
            system("adb shell 'touch -t $timestamp $caminho' > /dev/null 2>&1");
        }

        echo "✅ Datas ajustadas com sucesso.\n";

        system("adb shell 'am force-stop com.android.settings' > /dev/null 2>&1");
        sleep(1);
        system("adb shell 'am start -a android.settings.DATE_SETTINGS' > /dev/null 2>&1");
        echo "🕐 Reabrindo configurações de Data e Hora...\n";
        echo "✅ Pressione ENTER após ativar novamente.\n";
        fgets(STDIN);

        echo "🧹 Limpando logcat...
";
        system("adb shell 'logcat -c' > /dev/null 2>&1");

        // Limpar histórico do Termux
        echo "🧽 Limpando histórico do Termux...
";
        @unlink(getenv("HOME") . "/.bash_history");
        @unlink(getenv("HOME") . "/.zsh_history");
        system("history -c > /dev/null 2>&1");

        echo "📡 Tentando abrir Depuração por Wi-Fi...\n";
        system("adb shell 'am start -a android.settings.APPLICATION_DEVELOPMENT_SETTINGS' > /dev/null 2>&1");
        echo "⚠️ Se a tela de Depuração por Wi-Fi não abrir, acesse manualmente pelas Opções do Desenvolvedor.\n";
        echo "✅ Pressione ENTER após verificar.\n";
        fgets(STDIN);

        echo "📡 Tentando abrir Depuração por Wi-Fi...
";
        system("adb shell 'am start -a android.settings.APPLICATION_DEVELOPMENT_SETTINGS' > /dev/null 2>&1");
        echo "⚠️ Se a tela de Depuração por Wi-Fi não abrir, acesse manualmente pelas Opções do Desenvolvedor.
";
        echo "✅ Pressione ENTER após verificar.
";
        fgets(STDIN);

        echo "✅ Script finalizado com sucesso.
";
        sleep(2);
        echo "🚪 Fechando Termux por segurança...
";
        system("am force-stop com.termux > /dev/null 2>&1");
        break;

    case '2':
        echo color("\n[!] Saindo...\n", "red");
        exit;
        break;

    default:
        echo color("\n[!] Opção inválida!\n", "red");
        break;
}
?>
