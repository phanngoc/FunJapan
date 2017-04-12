function pollFunction(pageId, selectItemId, ticket, language) {
    var deferred = $.Deferred();

    var context = mpf.Context.getInstance();

    $.ajax({
        url: context.webApiSiteUrl + 'poll/' + pageId + '/' + selectItemId + '/applicant/' + context.currentUserId,
        type: 'post',
        data: { Ticket: ticket },
        headers: { 'X-MPF-AuthenticationTicket': context.authTicket, 'X-MPF-Language': language },
        success: deferred.resolve,
        error: deferred.reject
    });

    return deferred.promise();
}
