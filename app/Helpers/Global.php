<?php

function rupiah($amount){
    return 'Rp '.number_format($amount, 0, ',', '.');
}

function tgltime($tanggal){
    return date('d M Y H:i', strtotime($tanggal));
}