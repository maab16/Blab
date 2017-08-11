function addToCart(product_id,user_id,qty){

	var qty = $('#'+qty).val();
	console.log(qty);
	$.ajax({

		url 		: '/cart.php',
		type 		: 'get',
		dataType 	: 'json',
		data 		: {

				product_id : product_id,
				user_id : user_id,
				qty : qty
		},

		success	: function(data){

			if (data.exists !== undefined) {

				alert('Carted Successfully.');
				window.open('/products/' , '_self');
			}
			
		},
		error	: function(data){

			// console.log(data);

		}
	});
}

function updateCart(product_id,user_id,qty){

	var qty = $('#'+qty).val();
	console.log(qty);
	$.ajax({

		url 		: '/update_cart.php',
		type 		: 'get',
		dataType 	: 'json',
		data 		: {

				product_id : product_id,
				user_id : user_id,
				qty : qty
		},

		success	: function(data){

			if (data.exists !== undefined) {

				alert('Cart Updated Successfully.');
				window.open('/products/carts/' , '_self');
			}
			
		},
		error	: function(data){

			console.log(data);

		}
	});
}