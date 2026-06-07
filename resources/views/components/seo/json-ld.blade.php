@props(['data' => []])
@php
    /*
     * Emite JSON-LD de forma SEGURA. Los flags JSON_HEX_TAG/AMP/APOS/QUOT
     * convierten < > & ' " en \u00XX, de modo que es imposible un breakout
     * de </script> ni inyección XSS aunque el contenido venga de un usuario.
     */
    $json = json_encode(
        $data,
        JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
            | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT
    );
@endphp
<script type="application/ld+json">{!! $json !!}</script>
