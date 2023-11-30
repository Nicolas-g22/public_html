function afficherGraphAjax()
{
    $.getJSON('controleur.php', {action: 'getConsommations'})
            .done(function (donnees, stat, xhr) {
                var categories = donnees.categories;
              
                var tabSerie = donnees.series;
                const chart = Highcharts.chart('container', {
                    chart: {
                        type: 'column'  // bar, line, spline
                    },
                    title: {
                        text: 'Consommation de fruits '
                    },
                    xAxis: {
                        categories: categories
                    },
                    yAxis: {
                        title: {
                            text: 'Quantité'
                        }
                    },
                    series: tabSerie
                });
            })
            .fail(function (xhr, text, error) {
                console.log("param : " + JSON.stringify(xhr));
                console.log("status : " + text);
                console.log("error : " + error);
            })
}
$(document).ready(function () {
    afficherGraphAjax();
})