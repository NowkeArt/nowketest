// Modals

transition = 300;

$(".modal-trigger").on("click", function () {
    modal = $(this).attr("data-modal");
    action = $(this).attr("data-action");

    if (action == "open") {
        openModal($(this), modal);
    } else if (action == "close") {
        $(".modals, .modal").fadeOut(transition);
    } else if (action == "switch") {
        switchModals($(this), $(this).attr("data-switched"), modal);
    }
});

// Open Modal

function openModal(parent, modal) {
    opening = $(".modals, .modals #" + modal);
    
    $.each(parent.data(), function(name, value) {
        opening.find('#data-' + name).val(value).html(value);
    });

    opening.fadeIn(transition);
}

// Switch Modals

function switchModals(parent, old, modal) {
    $(".modals #" + old).fadeOut(transition, function () {
        openModal(parent, modal);
    });
}