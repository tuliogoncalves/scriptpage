<?php

/**
 * Inclui o arquivo de rotas de um módulo/área especifica.
 *
 * @return string
 */
if (!function_exists('incluirRota')) {
    function incluirRota($arquivo, $namespace)
    {
        require  base_path("routes/_routes/$namespace/$arquivo");
    }
}

/**
 * Remove máscara de um valor específico.
 *
 * @param  string $valor Valor para editar.
 * @param  mixed $outros Caso deseja passar outros valores a serem removidos.
 *
 * @return string
 */
function removerMascara($valor, $outros = null)
{
    $remover = [
        '.', ',', '/', '-', '(', ')', '[', ']', ' ', '+'
    ];

    if (!is_null($outros)) {
        if (!is_array($outros)) {
            $outros = [$outros];
        }
        $remover = array_merge($remover, $outros);
    }

    return str_replace($remover, '', $valor);
}
