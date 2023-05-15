<?php
use Illuminate\Support\Facades\Log;
use App\Models\Sys\JobHistory;

if(! function_exists('job_control') ){

    function job_control($job, $id = null){
        
        // Se o id do JobHistory for passado ele finaliza o running 
        if($id){
            $job = JobHistory::find($id);
            $job['running']  = '0';
            return  $job->save();
        } else {

            return   JobHistory::create($job);
        }
    }

}


// Esta função recebe uma string e a transforma em uma frase com a primeira letra de cada palavra em maiúscula,
// exceto para palavras específicas definidas em outras funções.
if (!function_exists('ucfirstException')) {
    function ucfirstException($string)
    {
        // Limpa o texto do excesso de espaços
        $string = preg_replace('/( )+/', ' ', $string);
        
        // Coloca todo o texto em maiúsculas 
        $string = mb_convert_case($string, MB_CASE_TITLE, 'UTF-8');

        // Separa o texto por palavras 
        $arr = explode(' ', $string);

        $tempArray = [];

        // percorre as palavras
        foreach ($arr as $value) {
            // substitui as palavras que devem ser minúsculas
            $word = keepLC($value);
            // substitui as palavras que devem ser maiúsculas
            $word = keepUC($word);
            // salva no array temporário
            array_push($tempArray, $word);
        };

        // junta as palavras novamente
        $string = implode(' ', $tempArray);

        return $string;
    }
}


// Esta função recebe uma string e verifica se ela está na lista de palavras que devem permanecer em minúsculas.
// Se estiver, a função retorna a string em minúsculas. Caso contrário, retorna a string original em maiúsculas.
if (!function_exists('keepLC')) {
    function keepLC($string)
    {
        // Lista de palavras que devem permanecer em minúsculas
        $keepLC = ['A', 'E', 'I', 'O', 'U', 'DA', 'DAS', 'DE', 'DES', 'DI', 'DIS', 'DO', 'DOS', 'DU', 'DUS'];

        // Limpa a string e a torna maiúscula para comparação
        $cleanWord = cleanWord($string);

        foreach ($keepLC as $value) {
            // Se a palavra estiver na lista, retorna em minúsculas
            $string = $cleanWord === $value ? mb_strtolower($string, 'UTF-8') : $string;
        };

        return $string;
    }
}

// Esta função recebe uma string e verifica se ela está na lista de palavras que devem permanecer em maiúsculas.
// Se estiver, a função retorna a string em maiúsculas. Caso contrário, retorna a string original em minúsculas.
if (!function_exists('keepUC')) {

    function keepUC($string)
    {
        // Lista de palavras que devem permanecer em maiúsculas
        $keepUC = ['PPV','CRV', 'ST', 'SKY', 'UF', 'RG', 'CPF', 'I', 'II', 'III', 'IV', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII', 'XIII', 'XIV', 'XV', 'XVI', 'XVII', 'XVIII', 'XVIII',];

        // Limpa a string e a torna maiúscula para comparação
        $cleanWord = cleanWord($string);

        foreach ($keepUC as $value) {
            // Se a palavra estiver na lista, retorna em maiúsculas
            $string = $cleanWord == $value ? mb_strtoupper($string, 'UTF-8') : $string;
        };

        return $string;
    }
}

if (!function_exists('cleanWord')) {
    function cleanWord($string)
    {
        // remove todos os caracteres especiais 
        $cleanWord =  preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities(trim($string)));
        $cleanWord =  preg_replace("/[^a-zA-Z\s]/", "", $cleanWord);
        $cleanWord =  mb_strtoupper(preg_replace('~\P{Xan}+~u', '', $cleanWord));
        $cleanWord = htmlentities(trim($cleanWord));

        return $cleanWord;
    }
}