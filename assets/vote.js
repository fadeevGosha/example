import $ from 'jquery';

$(function () {
    $('[data-item=votesButton]').each(function () {
        const root = $(this);
        root.on('click', function (e) {
            e.preventDefault();
            $.ajax({
                url: root.data('url'),
                method: 'POST'
            }).then(function (data) {

                let $voteCountDom = $('[data-item=voteCount]');
                let $voteCount = data.voteCount;

                if($voteCount !== 0)
                {
                    let $class = $voteCount > 0 ? "text-success" : "text-danger";
                    $voteCountDom.attr("class", $class);
                }
                else
                {
                    $voteCountDom.attr("class", '');
                }

                $voteCountDom.text($voteCount);
            });
        });
    });
});