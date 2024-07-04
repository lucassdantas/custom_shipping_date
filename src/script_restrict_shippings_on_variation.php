<?php 

defined('ABSPATH') or die();
if(!function_exists('add_action')){
    die;
}
add_action('woocommerce_after_add_to_cart_form', 'script_restrict_shippings_on_variation');
function script_restrict_shippings_on_variation()
{
?>
<script defer>
    document.addEventListener('DOMContentLoaded', function() {
        let variationSelector = document.querySelector("#pa_sucata") || null,
            cepInput = document.querySelector("#inputCep");
        
        if (!variationSelector || !cepInput) {
            return;
        }

        cepInput.addEventListener('input', () => {
            checkAndHideMethods();
        });

        const checkAndHideMethods = () => {
            if (variationSelector.value === 'sem-sucata') {
                const intervalId = setInterval(() => {
                    let rows = document.querySelectorAll('.resultado-frete tr');
                    if (rows.length > 0) {
                        let messageAdded = false;  
                        rows.forEach(tr => {
                            let td = tr.querySelector('td');
                            if (td && td.innerText !== 'Entrega Help Baterias : R$0,00') {
                                tr.style.display = 'none';
                                if (!messageAdded) {
                                    let messageRow = document.createElement('tr');
                                    let messageTd = document.createElement('td');
                                    messageTd.colSpan = td.colSpan;  
                                    messageTd.innerText = 'As entregas por transportadora não estão disponíveis para produtos com devolução de sucata.';
                                    messageRow.appendChild(messageTd);
                                    tr.parentNode.insertBefore(messageRow, tr.nextSibling);
                                    messageAdded = true;
                                }
                            }
                        });
                        clearInterval(intervalId);
                    }
                }, 100);  
            }
        };
    });
</script>

<?php 
}
