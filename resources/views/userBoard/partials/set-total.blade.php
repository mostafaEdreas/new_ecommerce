<script>
            function setTotal() {
            // Calculate the sum of product subtotals
            let productTotal = sum($('.sub-totat-product'));

            // Get the value of the selected shipping method and convert it to a number
            let shippingCost = parseFloat($('input[name="shipping_method"]:checked').val()) || 0;
            let paymentCost = parseFloat($('input[name="payment_method"]:checked').val()) || 0;
            let coupon_value = parseFloat($('#coupon-value').text()) || 0;

                console.log(shippingCost,paymentCost,coupon_value);

            // Update the total without shipping costs
            $('#total-without-shipping-costs').text(productTotal.toFixed(2));

            // Calculate and update the total with shipping costs
            let total = productTotal + shippingCost + paymentCost - coupon_value;
            $('#total-with-shipping-costs').text(total.toFixed(2));
        }

        function sum(elements) {
            let total = 0;
            elements.each(function() {
                let value = parseFloat($(this).val()) || parseFloat($(this).text()) || 0;
                total += value;
            });

            return total;
        }

        $(function() {
            $(document).on('change', '.shipping-method', function() {
                setTotal()
            })

            $(document).on('change', '.payment-method', function() {
                setTotal()
            })
            $(document).on('change', '#cobone-code', function() {
                setTotal()
            })

        })
</script>
