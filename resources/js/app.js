import './bootstrap';
import {initFlowbite} from "flowbite";
import ToastComponent from '../../vendor/usernotnull/tall-toasts/resources/js/tall-toasts'

Alpine.plugin(ToastComponent)

flatpickr(".dateInput", {
    minDate: "today",
    dateFormat: "Y-m-d",
});

document.addEventListener('livewire:navigated', () => {
    initFlowbite();
});

