add_action( 'wp_footer', 'f4d_replace_state_dropdown_with_text_input' );
function f4d_replace_state_dropdown_with_text_input() {
    if(!is_checkout()) return;
    ob_start();
    ?>
    <script>
    (function(){
        'use strict';
        // Check if is US and .woocommerce-input-wrapper contains select field
        window.checkForUnitedStatesDropdownStateField = setInterval(function () {
            var node = document.querySelector('[id="billing_state_field"]');
            if (node) {
                if (node.querySelector('.woocommerce-input-wrapper select')) {
                    // Has select
                    // Check if country is "US", if so replace...
                    var country = document.querySelector('select[id="billing_country"]');
                    if (country.value === 'US') {
                        window.convertStateDropdownToInputText();
                    } else {
                        // Do nothing
                    }
                } else {
                    // Already replaced
                    var country = document.querySelector('select[id="billing_country"]');
                    var field = node.querySelector('[name="billing_state"]');
                    if (country.value === 'US') {
                        if (field) field.maxLength = 2;
                    } else {
                        if (field) {
                            field.style.width = '';
                            field.removeAttribute('maxLength');
                        }
                    }

                }
            }
        }, 100);
        // Convert state dropdown into a normal text field
        window.convertStateDropdownToInputText = function () {
            //debugger;
            var country = document.querySelector('[id="billing_country"]');
            if (!country) return;
            var node = document.querySelector('[id="billing_state_field"]');
            if (node) {
                //debugger;
                var field = node.querySelector('[name="billing_state"]');
                var clone = node.cloneNode(true);
                node.parentNode.insertBefore(clone, node.nextElementSibling);
                clone.classList.remove('validate-state');
                clone.classList.remove('validate-required');
                clone.classList.remove('woocommerce-invalid');
                clone.classList.remove('woocommerce-invalid-required-field');
                clone.classList.remove('woocommerce-validated');
                debugger;
                console.log(clone.dataset);
                debugger;
                console.log(clone.dataset.o_class);
                if (clone.dataset.o_class) {
                    clone.dataset.o_class = clone.dataset.o_class.replace('validate-state', '');
                    clone.dataset.o_class = clone.dataset.o_class.replace('validate-required', '');
                }
                clone.querySelector('.woocommerce-input-wrapper').innerHtml = '';
                clone.querySelector('.woocommerce-input-wrapper').innerText = '';
                var newField = document.createElement('input');
                newField.type = 'text';
                newField.maxLength = 2;
                newField.className = 'input-text';
                newField.name = 'billing_state';
                newField.id = 'billing_state';
                newField.style.width = '220px';
                newField.autocomplete = (field.autocomplete ? field.autocomplete : 'address-level1');
                if (country.value === 'US') {
                    debugger;
                    newField.value = field.value;
                    newField.dataset.prevPlaceholder = newField.placeholder;
                    newField.placeholder = 'Two letter code e.g. NY';
                } else {
                    debugger;
                    newField.value = '';
                    newField.style.width = '';
                    newField.removeAttribute('maxLength');
                }
                clone.querySelector('.woocommerce-input-wrapper').appendChild(newField);
                node.remove();
            }
        };
        var country = document.querySelector('[id="billing_country"]');
        if (country && country.value === 'US') {
            // Is US
            window.convertStateDropdownToInputText();
        }
        // When country is changed replace dropdown again
        jQuery(document).ready(function ($) {
            $('#billing_country').on('change', function () {
                var node, field;
                if ($(this).val() === 'US') {
                    node = document.querySelector('[id="billing_state_field"]');
                    if (node) {
                        node.classList.remove('woocommerce-validated');
                    }
                    window.convertStateDropdownToInputText();
                } else {
                    node = document.querySelector('[id="billing_state_field"]');
                    if (node) {
                        node.classList.remove('woocommerce-validated');
                        field = node.querySelector('[name="billing_state"]');
                        field.style.width = '';
                        field.removeAttribute('maxLength');
                        field.placeholder = (field.dataset.prevPlaceholder ? field.dataset.prevPlaceholder : '');
                    }
                }
            });
            $('body').on('keyup blur change', '#billing_state', function () {
                var country = document.querySelector('[id="billing_country"]');
                if (country.value !== 'US') return;
                const wrapper = $(this).closest('.form-row');
                var error = false;
                // Check for validation errors
                var value = this.value.trim();
                // Conver to uppercase
                value = value.toUpperCase();
                value = value.replace(/[^A-Z]/g, '');
                this.value = value;
                if (/^[A-Z]{2}$/.test(value)) { // check if contains numbers
                    error = false;
                } else {
                    error = true;
                }
                wrapper.removeClass('woocommerce-invalid');
                wrapper.removeClass('woocommerce-validated');
                if (error) {
                    wrapper.addClass('woocommerce-invalid'); // error
                } else {
                    wrapper.addClass('woocommerce-validated'); // success
                }
            });
        });
    })();
    </script>
    <?php
    $js = ob_get_contents();
    ob_end_clean();
    echo $js;
}
