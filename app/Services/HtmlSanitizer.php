<?php

namespace App\Services;

use HTMLPurifier;
use HTMLPurifier_Config;

/**
 * Saneador de HTML enriquecido (contenido de TinyMCE).
 *
 * Usa HTMLPurifier con una allowlist estricta de etiquetas/atributos. Cualquier
 * cosa fuera de la lista (scripts, handlers on*, esquemas javascript:/data:, svg,
 * object/embed, iframes, etc.) se elimina. Reemplaza la antigua sanitización por
 * regex (lista negra) que era trivialmente evadible.
 */
class HtmlSanitizer
{
    private HTMLPurifier $purifier;

    public function __construct()
    {
        $config = HTMLPurifier_Config::createDefault();

        // Allowlist de etiquetas y atributos permitidos en el contenido del editor.
        $config->set('HTML.Allowed', implode(',', [
            'p[style]', 'br', 'hr', 'span[style]', 'div[style]',
            'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
            'strong', 'b', 'em', 'i', 'u', 's', 'strike', 'sub', 'sup', 'small',
            'blockquote', 'pre', 'code',
            'ul', 'ol[start]', 'li',
            'a[href|title|target|rel]',
            'img[src|alt|title|width|height]',
            'table', 'thead', 'tbody', 'tfoot', 'tr',
            'th[colspan|rowspan|scope]', 'td[colspan|rowspan]',
            'figure', 'figcaption',
            '*[class]',
        ]));

        // Propiedades CSS permitidas en atributos style (HTMLPurifier valida cada valor).
        $config->set('CSS.AllowedProperties', [
            'text-align', 'color', 'background-color',
            'font-weight', 'font-style', 'text-decoration',
            'padding-left', 'margin-left',
        ]);

        // Permitir enlaces que abren en una pestaña nueva; rel=noopener/noreferrer
        // se añade automáticamente (HTML.TargetNoopener/Noreferrer activos por defecto).
        $config->set('Attr.AllowedFrameTargets', ['_blank']);

        // Solo esquemas de URL seguros. javascript: y data: quedan bloqueados.
        $config->set('URI.AllowedSchemes', [
            'http' => true,
            'https' => true,
            'mailto' => true,
            'tel' => true,
        ]);

        // Cache de definiciones en storage (evita escribir dentro de vendor/).
        $cachePath = storage_path('app/htmlpurifier');
        if (! is_dir($cachePath)) {
            @mkdir($cachePath, 0775, true);
        }
        $config->set('Cache.SerializerPath', $cachePath);

        $this->purifier = new HTMLPurifier($config);
    }

    /**
     * Devuelve el HTML saneado y seguro para renderizar.
     */
    public function clean(?string $html): string
    {
        if ($html === null || trim($html) === '') {
            return '';
        }

        return $this->purifier->purify($html);
    }
}
