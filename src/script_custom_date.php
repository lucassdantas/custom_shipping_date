<?php

defined('ABSPATH') or die();
if(!function_exists('add_action')){
    die;
}
function script_custom_date()
{
?>
<script>
    
    if(location.pathname == '/finalizar-compra/'){
        let waitForElementToExist = (selector) => {
                return new Promise(resolve => {
                    if (document.querySelector(selector)) {
                        return resolve(document.querySelector(selector));
                    }

                    const observer = new MutationObserver(() => {
                        if (document.querySelector(selector)) {
                            resolve(document.querySelector(selector));
                            observer.disconnect();
                        }
                    });

                    observer.observe(document.body, {
                        subtree: true,
                        childList: true,
                    });
                });
            },
            ds = value => document.querySelector(value),
            c  = value => console.log(value),
            delivertTyleSelectTitle,
            date;

        waitForElementToExist('#shipping_type')
        .then( shippingType => {
            waitForElementToExist('#shipping_date_field')
            .then(shippingDateField => {
                
                let showShippingDateByShippingType = (shippingType, shippingDate) => {
                    if(shippingType.value !== "Entrega agendada"){
                        shippingDate.style.display = 'none'
                    }else{
                        shippingDate.style.display = ''
                    }
                },

                addBusinessDays = () => {
                    const today = new Date();
                    const dayOfWeek = today.getDay();
                    const daysToAdd = (dayOfWeek === 5) ? 3 : (dayOfWeek === 6) ? 2 : 1;
                    
                    today.setDate(today.getDate() + daysToAdd);
                    
                    // Garanta que a data seja formatada no formato "YYYY-MM-DD" para um input tipo date
                    const formattedDate = today.toISOString().split('T')[0];
                    
                    return formattedDate;
                    }


                showShippingDateByShippingType(shippingType, shippingDateField)
                shippingDateField.querySelector('.optional').innerHTML = '<small>(Entregaremos no próximo dia útil caso o selecionado não seja útil)</small>'
                let currentHour = new Date().getHours()
                if(currentHour > 17 && currentHour < 9) {
                    let shippingOption = shippingType.querySelector('option[value="Entrega imediata"]') || shippingType.querySelector('option[value="Entrega no mesmo dia"]')
                    if(shippingOption){
                        shippingType.removeChild(shippingOption)
                    }
                }
                let shippingDateInput = shippingDateField.querySelector('input');
                let currentDate = new Date();
                let currentDatePlusFiveBusinessDays = addBusinessDays(currentDate, 5);

                // Formate a data para "YYYY-MM-DD"
                const formattedDate = currentDatePlusFiveBusinessDays.split('/').reverse().join('-');
                console.log(formattedDate);

                shippingDateInput.value = formattedDate;
                shippingDateInput.setAttribute('min', formattedDate);




                shippingType.addEventListener('change', e => {
                    showShippingDateByShippingType(shippingType, shippingDateField)
                })

                shippingDateInput.addEventListener('change', e => {
                    date = new Date(shippingDateInput.valueAsNumber)
                    let dateValue = new Date(e.value);
                    if (dateValue < date) e.value = [date.getFullYear(), date.getMonth() + 1, date.getDate()].map(v => v < 10 ? '0' + v : v).join('-');
                    if(date.getUTCDay() == 0){
                        shippingDateInput.value = ''
                        alert('Só realizamos entregas em dias úteis')
                    }
                })
            })
        })
    }
</script>

<script>
    if(location.pathname === '/finalizar-compra/'){
        let waitForElementToExist = (selector) => {
            return new Promise(resolve => {
                if (document.querySelector(selector)) {
                    return resolve(document.querySelector(selector));
                }

                const observer = new MutationObserver(() => {
                    if (document.querySelector(selector)) {
                        resolve(document.querySelector(selector));
                        observer.disconnect();
                    }
                });

                observer.observe(document.body, {
                    subtree: true,
                    childList: true,
                });
            });
        },
        statusCheckerAndReload = {
            motoboyInputId:'shipping_method_0_help_baterias_shipping34',
            loadingBlockClass:'blockUI',
            element: document.querySelector(`#${this.motoboyInputId}`),
            wasChecked: false,
            isReloading: false,
            checker: undefined,
            radioBtns: document.querySelectorAll('.woocommerce-shipping-totals input'),
            isCheckedInterval(){
                waitForElementToExist(`#${statusCheckerAndReload.motoboyInputId}`).then(el => {
                    if(el.checked === true) {
                        statusCheckerAndReload.wasChecked = true
                        return true 
                    }
                    return false
                })
            },
            tryReloadPage() {
                statusCheckerAndReload.checker = setInterval( () => {
                    if(statusCheckerAndReload.wasChecked){
                        waitForElementToExist(`#${statusCheckerAndReload.motoboyInputId}`).then(el => {
                            if(!el.checked){
                                let test = document.querySelector(`.${statusCheckerAndReload.loadingBlockClass}`)
                                if(!document.querySelector(`.${statusCheckerAndReload.loadingBlockClass}`)){
                                    statusCheckerAndReload.isReloading = true  
                                    location.reload()
                                    clearInterval(statusCheckerAndReload.checker)
                                }
                            }
                        })
                    } else{
                        waitForElementToExist(`#${statusCheckerAndReload.motoboyInputId}`).then(el => {
                            if(el.checked){
                                let test = document.querySelector(`.${statusCheckerAndReload.loadingBlockClass}`)
                                if(!document.querySelector(`.${statusCheckerAndReload.loadingBlockClass}`)){
                                    statusCheckerAndReload.isReloading = true  
                                    location.reload()
                                    clearInterval(statusCheckerAndReload.checker)
                                }
                            }
                        })
                    }
                }, 600)
            },
            reloadOnClick(){
                statusCheckerAndReload.radioBtns = document.querySelectorAll('.woocommerce-shipping-totals input')
                statusCheckerAndReload.radioBtns.forEach(btn => {
                    btn.addEventListener('click', () => {
                        waitForElementToExist(`#${statusCheckerAndReload.motoboyInputId}`).then((el) => {
                            location.reload()
                        })
                    })
                })
            },
            init(){
                statusCheckerAndReload.isCheckedInterval()
                statusCheckerAndReload.tryReloadPage()
            }
        }
        statusCheckerAndReload.init()
    }
</script>

<?php
}

add_action('wp_footer', 'script_custom_date');

//blockUI blockOverlay