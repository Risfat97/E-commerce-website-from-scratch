$(document).ready(function(){
    $('.add-to-basket').click((e) => {
        let itemContainer = $($($(e.currentTarget).parent()).parent()).parent();
        let item = $(itemContainer).children(),
        detailItem = $(item).children();
        let url = $(item).attr('src'),
        name = $(detailItem[0]).text(),
        category = $(detailItem[1]).text(),
        price =  $(detailItem[2]).text().split(' ')[0];
        $.post('../projet_web/add_to_basket.php', {
            'name': name,
            'category': category,
            'url': url,
            'price': price,
            'quantity': 1
            }, (data) =>{
                let nbOrder = (+ $('.nb-order').text()) + 1;
                let p = $($(e.currentTarget).parent()).find('p.item-added');
                $('.nb-order').text(nbOrder);
                if(!p.hasClass("show-alerting"))
                    p.addClass("show-alerting");
        });
    });

    $('.remove-item').click((e) => {
        let itemContainer = $($(e.currentTarget).parent()).parent();
        let item = $(itemContainer).children();
        let detailItem = $($(item[1]).children()[0]).children();
        let url = $($(item[0]).children()).attr('src'),
        name = $(detailItem[0]).text(),
        category = $(detailItem[1]).text(),
        quantity = $(detailItem[2]).text().split(' ')[1],
        price =  $(detailItem[3]).text().split(' ')[0];
        $.post('../projet_web/remove_from_basket.php', {
            'name': name,
            'category': category,
            'url': url,
            'price': price,
            'quantity': quantity
            }, (data) =>{
                let nbOrder = (+ $('.nb-order').text()) - 1;
                $('.nb-order').text(nbOrder);
                window.location.reload();
        });
    });

    $('#filter-apply-btn').click((e) => {

        checkedBoxes = $('.form-check-input:checkbox:checked');
        checkBoxesNames = [];
        for (checkedBox of checkedBoxes)
        {
            checkBoxesNames.push(checkedBox.name);
        }

        minPrice = $('#min-price')[0].value;
        maxPrice = $('#max-price')[0].value;
        console.log([checkBoxesNames, minPrice, maxPrice]);
        $.post('../projet_web/filtrerArticles.php', {
            'categories': checkBoxesNames,
            'minPrice': minPrice,
            'maxPrice': maxPrice,
            'clear': false
        }, (data) => {
            window.location.reload();
        });
    });

    $('#filter-effacer-btn').click((e) => {
        $.post('../projet_web/filtrerArticles.php', {
            'clear': true
        }, (data) => {
            window.location.reload();
        })
    });

    $('#search-item-btn').click((e) => {
        var searchString = $('#search-item')[0].value;
        toSend = {};

        if (searchString === "")
        {
            console.log('empty');
            toSend = {
                'clear': true
            };
        }
        else
        {
            toSend = {
                'search': searchString,
                'clear': false
            }
        }

        $.post('../projet_web/filtrerArticles.php', toSend, 
        (data) => {
                window.location.reload();
        })
    });

    $('.del-from-repo').click((e) => {
        let itemContainer = $($($(e.currentTarget).parent()).parent()).parent();
        var item = $(itemContainer).children();
        var url = $(item).attr('src');
        $.post('../projet_web/adminDeleteItem.php', {
            'url': url,
            }, (data) =>{
                let nbOrder = (+ $('.nb-order').text()) + 1;
                let p = $($(e.currentTarget).parent()).find('p.item-added');
                $('.nb-order').text(nbOrder);
                if(!p.hasClass("show-alerting"))
                    p.addClass("show-alerting");

                window.location.reload();
        });
    });
});