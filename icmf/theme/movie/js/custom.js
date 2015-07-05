function randInfo(){
	$('#randInfo').fadeIn(2000);
	
//	 $(this).effect("transfer", { to: $("#div2") }, 1000);
	 $("#content").effect("transfer", { to: "#leftSide", className: "transferDiv"}, 500);
	 loader('POST', '', 'leftSideContent', 'op=draw&mode=c_listWinner');
}

function barChart(){
	
	var s1 = [24458, 76962];
    // Can specify a custom tick Array.
    // Ticks should match up one for each y value (category) in the series.
    var ticks = ['فروردین', 'اردیبهشت'];
     
    var plot1 = $.jqplot('chart', [s1], {
        // The seriesDefaults option is an options object that will
        // be applied to all series in the chart.
        seriesDefaults:{
            renderer:$.jqplot.BarRenderer,
            rendererOptions: {fillToZero: true},
            pointLabels: { show: true, location: 'e', edgeTolerance: -15 }
        },
        axes: {
            // Use a category axis on the x axis and use our custom ticks.
            xaxis: {
                renderer: $.jqplot.CategoryAxisRenderer,
                ticks: ticks
            },
            // Pad the y axis just a little so bars can get close to, but
            // not touch, the grid boundaries.  1.2 is the default padding.
            yaxis: {
                pad: 1.05,
                tickOptions: {formatString: '%d'}
            }
        }
    });
}