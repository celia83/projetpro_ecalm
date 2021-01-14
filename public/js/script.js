
$("#getResults").click(function () {
    var corpus = $("#corpus > option:selected").val();
    console.log(corpus);
    var level = $("#level > option:selected").val();
    var pos = $("#pos > option:selected").val();
    var errStatus = $("#errStatus > option:selected").val();
    var segmStatus = $("#segmStatus > option:selected").val();
    var lemma = $("#lemma").val();
    $.ajax({
        url: 'index.php?action=showGeneralResults',
        method: 'POST',
        data: 'corpus=' + corpus + '&level=' + level + '&pos=' + pos+ '&errStatus=' + errStatus+ '&segmStatus=' + segmStatus + '&lemma='+lemma,
        success: function (result) {
            console.log(result);
            $("#resultsDiv").html(result);
        }
    })
})