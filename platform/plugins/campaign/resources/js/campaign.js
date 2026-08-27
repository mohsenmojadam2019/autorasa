$(() => {
    const $campaignPopup = $('#campaign-popup')

    const dontShowAgain = (time) => {
        const date = new Date()
        date.setTime(date.getTime() + time)
        document.cookie = `campaign_popup=1; expires=${date.toUTCString()}; path=/`
    }

    if ($campaignPopup.length > 0) {
        if (document.cookie.indexOf('campaign_popup=1') === -1) {
            setTimeout(() => {
                $campaignPopup.modal('show')
            }, $campaignPopup.data('delay') * 1000)
        }

        $campaignPopup
            .on('show.bs.modal', () => {
                const dialog = $campaignPopup.find('.modal-dialog')

                dialog.css('margin-top', (Math.max(0, ($(window).height() - dialog.height()) / 2) / 2))
            })
            .on('hide.bs.modal', () => {
                const checkbox = $campaignPopup.find('form').find('input[name="dont_show_again"]')

                if (checkbox.is(':checked')) {
                    dontShowAgain(3 * 24 * 60 * 60 * 1000) // 1 day
                } else {
                    dontShowAgain(60 * 60 * 1000) // 1 hour
                }
            })

        document.addEventListener('campaign.subscribed', () => dontShowAgain())

        let showError = function (message) {
            $('.campaign-error-message').html(message).show()
        }

        let showSuccess = function (message) {
            $('.campaign-success-message').html(message).show()
        }

        let handleError = function (data) {
            if (typeof data.errors !== 'undefined' && data.errors.length) {
                handleValidationError(data.errors)
            } else {
                if (typeof data.responseJSON !== 'undefined') {
                    if (typeof data.responseJSON.errors !== 'undefined') {
                        if (data.status === 422) {
                            handleValidationError(data.responseJSON.errors)
                        }
                    } else if (typeof data.responseJSON.message !== 'undefined') {
                        showError(data.responseJSON.message)
                    } else {
                        $.each(data.responseJSON, (index, el) => {
                            $.each(el, (key, item) => {
                                showError(item)
                            })
                        })
                    }
                } else {
                    showError(data.statusText)
                }
            }
        }

        let handleValidationError = function (errors) {
            let message = ''
            $.each(errors, (index, item) => {
                if (message !== '') {
                    message += '<br />'
                }
                message += item
            })
            showError(message)
        }

        $(document).on('submit', 'form.bb-campaign-popup-form', (e) => {
            e.preventDefault()

            const $form = $(e.currentTarget)
            const $button = $form.find('button[type=submit]')

            $('.campaign-success-message').html('').hide()
            $('.campaign-error-message').html('').hide()

            $.ajax({
                type: 'POST',
                cache: false,
                url: $form.prop('action'),
                data: new FormData($form[0]),
                contentType: false,
                processData: false,
                beforeSend: () => $button.prop('disabled', true).addClass('btn-loading'),
                success: ({ error, message }) => {
                    if (error) {
                        showError(message)

                        return
                    }

                    $form.find('input[name="email"]').val('')

                    showSuccess(message)

                    document.dispatchEvent(new CustomEvent('campaign.subscribed'))

                    setTimeout(() => {
                        $campaignPopup.modal('hide')
                    }, 5000)
                },
                error: (error) => handleError(error),
                complete: () => {
                    if (typeof refreshRecaptcha !== 'undefined') {
                        refreshRecaptcha()
                    }

                    $button.prop('disabled', false).removeClass('btn-loading')
                },
            })
        })
    }
})
