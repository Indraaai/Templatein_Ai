import './bootstrap';
import './rules-builder';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Import Template Builder for global access
import { TemplateBuilder } from './template-builder/TemplateBuilder.js';
import { SectionManager } from './template-builder/SectionManager.js';
import { showAlert, getSkripsiTemplate, getProposalTemplate } from './template-builder/utils.js';

// Make Template Builder available globally
window.TemplateBuilder = TemplateBuilder;
window.SectionManager = SectionManager;
window.TemplateBuilderUtils = {
    showAlert,
    getSkripsiTemplate,
    getProposalTemplate
};
