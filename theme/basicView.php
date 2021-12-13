<?php
/**
 * [ php config ] Altera modo de exibição do var_dump.
 * overload_var_dump: Omitir a linha de caminho do var_dump.
 */
ini_set('xdebug.overload_var_dump', 1);


/**
 * [ interface ] Style, icon and logo
 */
echo "<link rel='stylesheet' href='theme/assets/css/style.css'/>",
"<link rel='icon' href='theme/assets/images/money-bag.png'/>",
"<img class='logo' src='theme/assets/images/bank.png'/>";


/**
 * [ Title Function ] Cria o título da página
 */
/**
 * @param mixed $titleName
 * 
 * @return [type]
 */
function namePage($titleName)
{
    echo "<title>{$titleName}</title>";
}


/**
 * [ Debug session ] Cria uma linha de sessão para exemplos
 * $line = __LINE__
 * $color = black | gray | red | green | yellow | blue
 */
/**
 * @param string $session
 * @param string $line
 * @param string|null $color
 * 
 * @return [type]
 */
function nameSession(string $session, string $line, string $color = "")
{
    $line = (!empty($line) ? " <span class='line-session'>| Linha {$line}</span>" : "");
    $session = (!empty($session) ? "[ {$session}{$line} ]" : "");
    $color = (!empty($color) ? "var(--{$color})" : "");
    echo "<div class='code line' style='background-color: {$color}'>{$session}</div>";
}