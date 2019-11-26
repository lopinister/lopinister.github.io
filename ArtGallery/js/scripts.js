$(document).ready(function() {
    // when the user clicks on like
    $('.like').on('click', function() {
        var artID = $(this).data('id');
        $post = $(this);

        $.ajax({
            url: 'like.php',
            type: 'post',
            data: {
                'liked': 1,
                'artID': artID
            },
            success: function(response) {
                $post.parent().find('span.likes_count').text(response + " likes");
                $post.addClass('hide');
                $post.siblings().removeClass('hide');
            }
        });
    });

    // when the user clicks on unlike
    $('.unlike').on('click', function() {
        var artID = $(this).data('id');
        $post = $(this);

        $.ajax({
            url: 'unlike.php',
            type: 'post',
            data: {
                'unliked': 1,
                'artID': artID
            },
            success: function(response) {
                $post.parent().find('span.likes_count').text(response + " likes");
                $post.addClass('hide');
                $post.siblings().removeClass('hide');
            }
        });
    });
});