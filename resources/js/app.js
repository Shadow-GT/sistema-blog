import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import FroalaEditor from 'froala-editor'

import 'froala-editor/css/froala_editor.pkgd.css'
import 'froala-editor/js/plugins.pkgd.min.js'

window.FroalaEditor = FroalaEditor;

import tinymce from 'tinymce/tinymce';
window.tinymce = tinymce; // Hacerlo disponible globalmente

/** Import tinymce main files */

import 'tinymce/skins/ui/oxide/skin';
import 'tinymce/skins/ui/oxide/content';
import 'tinymce/skins/content/default/content';
import 'tinymce/icons/default/icons';
import 'tinymce/themes/silver/theme';
import 'tinymce/models/dom/model';

/** Import all plugin */
import 'tinymce/plugins/media';
import 'tinymce/plugins/image';
import 'tinymce/plugins/autosave';
import 'tinymce/plugins/autolink';
import 'tinymce/plugins/link';
import 'tinymce/plugins/lists';
import 'tinymce/plugins/table';
import 'tinymce/plugins/autoresize';
import 'tinymce/plugins/preview';
import 'tinymce/plugins/wordcount';
