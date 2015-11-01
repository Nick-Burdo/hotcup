$.getJSON('data/price.json', {}, function(data) {
    var Price = data;

    // первый выбор продукта
    $("#teacafe").change(function() {
        $("tr.price-string").css("display","none");
        $("tr.price-string").eq($(this).val()).css("display","table-row");
    }).change();

// второй выбор продукта
    $("select.name2").change(function() {
        var value = $(this).val();
        var id = $(this).attr('id').toString();
        var qnt = $(this).parent().next().next().next().next().next().find("input").val();
        var sum = Price[id].p[value] * qnt;
        var p00 = Price[id].p[value];
        $(this).parent().next().text(Price[id].w[value]);
        $(this).parent().next().next().text(Price[id].q[value]);
        $(this).parent().next().next().next().text(Price[id].c[value]);
        $(this).parent().next().next().next().next().text(p00.toFixed(2));
        $(this).parent().next().next().next().next().next().next().text(sum.toFixed(2));
    }).change();

// выбор количества товара
    $("input").change(function() {
        var price = $(this).parent().prev().text();
        var sum = price * $(this).val();
        $(this).parent().next().text(sum.toFixed(2));
    });

// добавление продукта
    $("td.addItem").click(function() {
        var selector = $(this).parent().find("select.name2");
        var value = selector.val();
        var id = selector.attr('id').toString();
        var name2 = Price[id].n[value];
        var qnt = $(this).prev().prev().find("input").val();
        var sum = $(this).prev().text();
        var row = $(this).parent().clone().removeClass("price-string").addClass("selectedItem");
        row.find("td").eq(0).html(name2);
        row.find("td").eq(5).html(qnt);
        row.find("td").eq(7).removeClass("addItem").addClass("delItem").html("<span>x</span>").click(function() {
            $(this).parent().remove();
            recalcTotal(-sum);
        });
        row.appendTo("#orderTable");
        recalcTotal(sum);
    });

// переход на 2 этап
    $("#next_step").click(function(){
        var order = $("#orderTable").clone();
        order.find("#teacafe").remove();
        order.find(".price-string").remove();
        order.find(".delItem").text('').width(0);
        order.find("#order_title").remove();
        order.append($("#totalSum").parent().parent().clone());
        $("#order_text").val(order.html());
        document.location.href = "#step2";
    });

// пересчет общей суммы
    function recalcTotal(value) {
        var sum = $("#totalSum").text();
        var total = sum*1 + value*1;
        $("#totalSum").text(total.toFixed(2));
        if(sum*1 + value*1 >= 2500)
            $("#next_step").removeAttr("disabled");
        else
            $("#next_step").attr("disabled",1);
    }
});








