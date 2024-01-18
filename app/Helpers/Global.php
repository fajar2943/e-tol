<?php

function rupiah($amount){
    return 'Rp '.number_format($amount, 0, ',', '.');
}