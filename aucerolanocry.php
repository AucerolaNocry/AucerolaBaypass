<?php
// Limpeza de tela
function clear_screen() {
    system('clear');
}

// Banner principal
function show_banner() {
    echo "============================================\n";
    echo "      KellerSS - Android Cheaters Utility   \n";
    echo "============================================\n";
    echo " 1) Verificar dispositivo ADB\n";
    echo " 2) Verificar Free Fire instalado\n";
    echo " 3) Verificar root no dispositivo\n";
    echo " 4) Atualizar script\n";
    echo " 5) Sair\n";
    echo "============================================\n";
}

// Verifica se dispositivo está conectado via ADB
function verificar_dispositivo() {
    $output = shell_exec("adb devices");
    if (strpos($output, "device") !== false && strpos($output, "List of devices") === false) {
        echo "[OK] Dispositivo ADB conectado!\n";
    } else {
        echo "[ERRO] Nenhum dispositivo conectado via ADB!\n";
    }
}

// Verifica se o Free Fire está instalado
function verificar_freefire() {
    $output = shell_exec("adb shell pm list packages | grep freefire");
    if (strpos($output, "com.dts.freefireth") !== false) {
        echo "[OK] Free Fire está instalado!\n";
    } else {
        echo "[ERRO] Free Fire NÃO está instalado!\n";
    }
}

// Loop principal do menu
function main_menu() {
    while (true) {
        clear_screen();
        show_banner();
        $option = readline("Escolha uma opção: ");
        switch ($option) {
            case '1':
                verificar_dispositivo();
                break;
            case '2':
                verificar_freefire();
                break;
            case '3':
                // Função de root entra aqui
                break;
            case '4':
                atualizar_script();
                break;
            case '5':
                echo "Saindo...\n";
                exit;
            default:
                echo "Opção inválida, tente novamente!\n";
        }
        readline("Pressione ENTER para continuar...");
    }
}
