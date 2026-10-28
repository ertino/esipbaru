@yield('js_code')

<script type="text/javascript">
var msg = '{{Session::get('alert')}}';
var exist = '{{Session::has('alert')}}';
if(exist){
  alert(msg);
}

//$('.rt4').html(accounting.formatMoney(data.retribusi_tunai, "Rp. ", 0, ".", ","))



function getDataChart() {
	var colorun = ["#eb3434", "#eb7434", "#eba534", "#dceb34", "#7aeb34", "#34eb83","#34ebdc", "#3496eb", "#4c34eb", "#b434eb", "#eb34d3", "#eb3483"];
	var satuan = '';

		$.ajax({
			type: 'ajax',
			method: 'get',
			url: '{{route("history.pajak")}}',
			data : {_token: "{{ csrf_token() }}"}, 
			async: false,
			dataType: 'json',
			success: function(chartvalue){
				//console.log(chartvalue);
								
			$.ajax({
				type: 'ajax',
				method: 'get',
				url: '{{ route("chart.detil") }}',
				data: {'detailnya': 'jenis_pajak', _token: "{{ csrf_token() }}"},
				async: false,
				dataType: 'json',
				success: function(chartlabel){
				//console.log(chartlabel);

				$.ajax({
					type: 'ajax',
					method: 'get',
					url: '{{ route("chart.detil") }}',
					data: {'detailnya': 'periode' , _token: "{{ csrf_token() }}"},
					async: false,
					dataType: 'json',
					success: function(chartperiode){
						//console.log(chartperiode)
									//alert(chartperiode.length);
						var config = {};
						var config = {
							type: 'bar',
							data: {
								labels: chartperiode[0],
								datasets: [{
								}]
							},
							options: {
								responsive: true,
								title: {
									display: true,
									text: 'Hasil Realisasi Pajak'
								},
								
								scales: {
									xAxes: [{
										display: true,
										scaleLabel: {
											display: true,
											labelString: 'Periode'
										},
										//stacked: true
									}],
									yAxes: [{
										display: true,
										scaleLabel: {
											display: true,
											labelString: 'Total Realisasi'
										},
										//stacked: true 
									}]
								}
							}
						};
						config.data.datasets.splice(0, 1);
						for(i=0; i<chartlabel.length; i++){
						var newDataset = {
							label: chartlabel[i],
							backgroundColor: colorun[i],
							borderColor: colorun[i],
							data: chartvalue[i],
							fill: false
						};
						
						config.data.datasets.push(newDataset);
										
									
						}
						createChart('create',config);
						//console.log(config);

					},
					error: function(request, status, error){
						alert(request.responseText);
					}
				});
								
			},
					error: function(request, status, error){
				alert(request.responseText);
			}
		});

		},
		error: function(request, status, error){
			alert(request.responseText);
		}
	});


 }
		////////////////////// destroy chart JS //////////////////////////
	function createChart(type,config) {
		if (type == "destroy"){
			var ctx = $('.timeline');
			var myChart = new Chart(ctx, config);
			myChart.destroy();
		} else {

			
			$('canvas#canvase').remove();
			$('div#creport').append('<canvas id="canvase" class="timeline"></canvas>');
			//$('<canvas id="canvase" class="timeline"></canvas>').appendTo("#creport");
			
			

			var ctx = $('.timeline');
		var myChart = new Chart(ctx, config);
		}

	}
//////////////////////////

getDataChart();

</script>


</html>
