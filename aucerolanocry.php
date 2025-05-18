<?php
// Definição de cores para facilitar a leitura do terminal
$reset    = "\033[0m";
$bold     = "\033[1m";
$verde    = "\033[32m";
$vermelho = "\033[31m";
$amarelo  = "\033[33m";
$azul     = "\033[36m";
$branco   = "\033[97m";

// Função para exibir o banner do script
function exibirBanner() {
    global $azul, $reset, $bold;
    echo $azul . "
  _  __     _ _      _   _____ _____ 
 | |/ /    | | |    | | |_   _|  __ \\
 ' <   ___ | | | ___| |__ | | | |  | |
 | |\\ \\ / _ \\| | |/ __| '_ \\| | | |  | |
 | |\\  \\  __/| | | (__| | | | |_| |  | |
 |_| \\_\\___||_|_|\\___|_| |_|_____/ 
" . $reset;
    echo $bold . "Coded By - KellerSS | Credits for Sheik\n\n" . $reset;
}

// Função principal do menu
function menuPrincipal() {
    global $verde, $amarelo, $azul, $reset;
    echo $azul . "===== MENU PRINCIPAL =====\n" . $reset;
    echo $verde . "1. Verificar dispositivo (ADB)\n" . $reset;
    echo $amarelo . "2. Verificar Free Fire\n" . $reset;
    echo $amarelo . "3. Verificar Root\n" . $reset;
    echo $azul . "4. Atualizar script\n" . $reset;
    echo "0. Sair\n";
    echo "Escolha uma opção: ";
}

// Função para verificar a conexão com o dispositivo via ADB
function verificarDispositivoAdb() {
    global $bold, $vermelho, $azul, $reset;

    system('clear');
    exibirBanner();

    // Checa se o ADB está instalado
    if (!shell_exec('adb version > /dev/null 2>&1')) {
        echo $bold . $vermelho . "[!] ADB não encontrado! Instalando...\n" . $reset;
        system('pkg install -y android-tools > /dev/null 2>&1');
    }

    // Inicia o servidor ADB e tenta detectar dispositivo
    shell_exec('adb start-server > /dev/null 2>&1');
    $comandoDispositivos = shell_exec('adb devices 2>&1');

    if (empty($comandoDispositivos) || strpos($comandoDispositivos, "device") === false || strpos($comandoDispositivos, "no devices") !== false) {
        echo $bold . $vermelho . "[!] Nenhum dispositivo encontrado. Faça o pareamento de IP ou conecte via USB.\n" . $reset;
        exit;
    }

    // Verifica se há mais de um dispositivo/emulador
    $comandoVerificarFF = shell_exec('adb shell pm list packages | grep com.dts.freefireth 2>&1');
    if (!empty($comandoVerificarFF) && strpos($comandoVerificarFF, "more than one device/emulator") !== false) {
        echo $bold . $vermelho . "[!] Mais de um dispositivo/emulador detectado! Use \"adb disconnect\" e tente novamente.\n" . $reset;
        exit;
    }

    // Confirma se Free Fire está instalado
    if (empty($comandoVerificarFF) || strpos($comandoVerificarFF, "com.dts.freefireth") === false) {
        echo $bold . $vermelho . "[!] Free Fire não encontrado no dispositivo!\n" . $reset;
        exit;
    }

    // Exibe a versão do Android
    $versaoAndroid = trim(shell_exec('adb shell getprop ro.build.version.release'));
    if (!empty($versaoAndroid)) {
        echo $bold . $azul . "[+] Versão do Android: {$versaoAndroid}\n" . $reset;
    } else {
        echo $bold . $vermelho . "[!] Não foi possível detectar a versão do Android!\n" . $reset;
    }
}

// --- Execução do script ---
// Mostra banner e menu principal
system('clear');
exibirBanner();
menuPrincipal();

// Exemplo de como chamar a função após input do usuário:
// $opcao = trim(fgets(STDIN));
// if ($opcao == "1") {
//     verificarDispositivoAdb();
// }
