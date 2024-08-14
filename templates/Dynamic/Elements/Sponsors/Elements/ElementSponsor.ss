<% if $Title && $ShowTitle %><h2 class="element__title">$Title</h2><% end_if %>
<% if $Content %><div class="element__content">$Content</div><% end_if %>

<% if $SponsorsList %>
    <div class="row element__sponsors__list">
        <% loop $SponsorsList %>
            <div class="col-md-3 card sponsors__list__sponsor">
                <% if $Image %>
                    <% if $ElementLink.URL %><a href="$ElementLink.URL" title="$ElementLink.Title"<% if $ElementLink.OpenInNew %> target="_blank" rel="noopener noreferrer"<% end_if %>><% end_if %>
                    <img src="$Image.Pad(576,576).URL" class="img-fluid card-img-top" alt="$Title.ATT"><% end_if %>
                    <% if $ElementLink.URL %></a><% end_if %>
                <div class="card-body">
                    <% if $Title && $ShowTitle %><h3 class="card-title">$Title</h3><% end_if %>
                    <% if $Content %><div class="card-text">$Content</div><% end_if %>
                </div>
\            </div>
            <% if $MultipleOf(4,1) && not Last %>
            </div>
            <div class="row sponsors-list">
            <% end_if %>
        <% end_loop %>
    </div>
<% end_if %>
