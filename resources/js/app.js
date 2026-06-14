import flatpickr from "flatpickr";
import { Indonesian } from "flatpickr/dist/l10n/id.js";
flatpickr.localize(Indonesian);
import TomSelect from "tom-select";
import "./bootstrap";
import "./../../vendor/power-components/livewire-powergrid/dist/powergrid";

// @ts-ignore
window.TomSelect = TomSelect;
window.flatpickr = flatpickr;

// import Alpine from 'alpinejs';
// window.Alpine = Alpine;
// Alpine.start();
