import './bootstrap';
import {initFlowbite} from "flowbite";
import ToastComponent from '../../vendor/usernotnull/tall-toasts/resources/js/tall-toasts'

Alpine.plugin(ToastComponent)
document.addEventListener('livewire:navigated', () => {
    initFlowbite();
})
