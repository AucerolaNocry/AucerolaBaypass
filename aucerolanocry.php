<?php

// Cores ANSI
$cln = "\033[0m";       // Reset
$bold = "\033[1m";      // Negrito
$preto = "\033[30m";    // Preto
$vermelho = "\033[91m"; // Vermelho
$verde = "\033[92m";    // Verde
$amarelo = "\033[93m";  // Amarelo
$azul = "\033[34m";     // Azul
$magenta = "\033[35m";  // Magenta
$ciano = "\033[36m";    // Ciano
$branco = "\033[97m";   // Branco
$fverde = "\033[32m";   // Verde claro

// Cores de fundo
$vermelhobg = "\033[101m";
$verdebg = "\033[42m";
$amarelobg = "\033[43m";
$azulbg = "\033[44m";
$lazulbg = "\033[106m";
$lverdebg = "\033[102m";

function keller_banner() {
    global $cln, $bold, $azul;
    
    echo $azul . "
    ██╗  ██╗███████╗██╗     ██╗     ███████╗██████╗ ███████╗██████╗ 
    ██║ ██╔╝██╔════╝██║     ██║     ██╔════╝██╔══██╗██╔════╝██╔══██╗
    █████╔╝ █████╗  ██║     ██║     █████╗  ██████╔╝█████╗  ██████╔╝
    ██╔═██╗ ██╔══╝  ██║     ██║     ██╔══╝  ██╔══██╗██╔══╝  ██╔══██╗
    ██║  ██╗███████╗███████╗███████╗███████╗██║  ██║███████╗██║  ██║
    ╚═╝  ╚═╝╚══════╝╚══════╝╚══════╝╚══════╝╚═╝  ╚═╝╚══════╝╚═╝  ╚═╝
    
    {$cln}{$bold}Coded By - KellerSS | Credits for Sheik
    ";
}

function atualizar() {
    global $cln, $bold, $fverde;
    echo $cln;
    system("git fetch origin && git reset --hard origin/master && git clean -f -d");
    echo $bold . $fverde . "Atualização concluída!" . $cln;
    die;
}

function inputusuario($message) {
    global $branco, $bold, $verdebg, $vermelhobg, $azulbg, $cln, $lazul, $fverde;
    $inputstyle = $cln . $bold . $lazul . "[#] " . $message . ": " . $fverde;
    echo $inputstyle;
    return trim(fgets(STDIN, 1024));
}

function verificar_freefire_th() {
    global $bold, $vermelho, $azul, $amarelo, $branco, $fverde, $cln;
    
    system("clear");
    keller_banner();
    
    // Verificar se ADB está instalado
    if (!shell_exec("adb version > /dev/null 2>&1")) {
        system("pkg install -y android-tools > /dev/null 2>&1");
    }
    
    date_default_timezone_set("America/Sao_Paulo");
    shell_exec("adb start-server > /dev/null 2>&1");
    
    // Verificar dispositivos conectados
    $comandoDispositivos = shell_exec("adb devices 2>&1");
    if (empty($comandoDispositivos) || strpos($comandoDispositivos, "device") === false || strpos($comandoDispositivos, "no devices") !== false) {
        echo $bold . $vermelho . "[!] Nenhum dispositivo encontrado. Faça o pareamento de IP ou conecte um dispositivo via USB.\n" . $cln;
        die;
    }
    
    // Verificar se Free Fire TH está instalado
    $comandoVerificarFF = shell_exec("adb shell pm list packages | grep com.dts.freefireth 2>&1");
    if (!empty($comandoVerificarFF) && strpos($comandoVerificarFF, "more than one device/emulator") !== false) {
        echo $bold . $vermelho . "[!] Pareamento realizado de maneira incorreta, digite 'adb disconnect' e refaça o processo.\n" . $cln;
        die;
    }
    
    if (empty($comandoVerificarFF) {
        echo $bold . $vermelho . "[!] Free Fire TH não está instalado no dispositivo.\n" . $cln;
        die;
    }
    
    // Verificação de root
    $comandoVerificacoes = array(
        "test_adb" => "adb shell echo ADB_OK 2>/dev/null",
        "su_bin1" => "adb shell \"[ -f /system/bin/su ] && echo found\" 2>/dev/null",
        "su_bin2" => "adb shell \"[ -f /system/xbin/su ] && echo found\" 2>/dev/null",
        "su_funciona" => "adb shell su -c \"id\" 2>/dev/null",
        "which_su" => "adb shell \"which su\" 2>/dev/null",
        "magisk_ver" => "adb shell \"su -c magisk --version\" 2>/dev/null",
        "adb_root" => "adb root 2>/dev/null"
    );
    
    $rootDetectado = false;
    foreach ($comandoVerificacoes as $comando) {
        $resultado = shell_exec($comando);
        if (!empty($resultado) {
            $rootDetectado = true;
            break;
        }
    }
    
    if ($rootDetectado) {
        echo $bold . $vermelho . "[+] Root detectado no dispositivo Android.\n";
    } else {
        echo $bold . $fverde . "[-] O dispositivo não tem root.\n";
    }
    
    // Verificar alterações de horário
    echo $bold . $azul . "[+] Verificando mudanças de data/hora...\n";
    $logcatOutput = shell_exec("adb logcat -d | grep \"UsageStatsService: Time changed\" | grep -v \"HCALL\"");
    
    if (!empty($logcatOutput)) {
        echo $bold . $amarelo . "[!] Alterações de horário detectadas.\n";
    } else {
        echo $bold . $fverde . "[-] Nenhuma alteração de horário detectada.\n";
    }
    
    // Verificar arquivos de replay
    echo $bold . $azul . "[+] Checando se o replay foi passado...\n";
    $comandoArquivos = "adb shell \"ls -t /sdcard/Android/data/com.dts.freefireth/files/MReplays/*.bin 2>/dev/null\"";
    $output = shell_exec($comandoArquivos) ?? '';
    $arquivos = array_filter(explode("\n", trim($output)));
    
    if (empty($arquivos)) {
        echo $bold . $vermelho . "[!] Nenhum arquivo .bin encontrado na pasta MReplays\n";
    } else {
        echo $bold . $fverde . "[i] Arquivos de replay encontrados.\n";
    }
    
    // Verificar shaders
    echo $bold . $azul . "[+] Verificando arquivos de shaders...\n";
    $pastaShaders = "/sdcard/Android/data/com.dts.freefireth/files/contentcache/Optional/android/gameassetbundles";
    $comandoShaders = "adb shell \"find " . escapeshellarg($pastaShaders) . " -name \"shaders*\" -type f 2>/dev/null\"";
    $arquivosShaders = shell_exec($comandoShaders);
    
    if (!empty($arquivosShaders)) {
        echo $bold . $amarelo . "[!] Arquivos de shaders encontrados.\n";
    } else {
        echo $bold . $fverde . "[-] Nenhum arquivo de shader encontrado.\n";
    }
    
    echo $bold . $branco . "\n[+] Scan completo. Verifique os resultados acima.\n" . $cln;
}

function verificar_freefire_max() {
    // Implementação similar à verificar_freefire_th() mas para Free Fire MAX
    // [... código omitido por brevidade ...]
}

// Menu principal
system("clear");
keller_banner();

echo $amarelo . " [1] Scanner Free Fire TH\n";
echo $amarelo . " [2] Scanner Free Fire MAX\n";
echo $amarelo . " [3] Atualizar Scanner\n";
echo $amarelo . " [0] Sair\n\n";

$opcao = inputusuario("Escolha uma opção");

switch ($opcao) {
    case '1':
        verificar_freefire_th();
        break;
    case '2':
        verificar_freefire_max();
        break;
    case '3':
        atualizar();
        break;
    case '0':
        echo "\nObrigado por usar o KellerSS Scanner!\n";
        die;
    default:
        echo $bold . $vermelho . "Opção inválida!\n" . $cln;
        break;
}
