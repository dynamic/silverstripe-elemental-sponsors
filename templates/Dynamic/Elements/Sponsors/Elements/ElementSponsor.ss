<% if $Title && $ShowTitle %><h2 class="element__title">$Title</h2><% end_if %>

<% if $Content %>
    <div class="element__content typography">$Content</div>
<% end_if %>

<% if $SponsorsList %>
    <div class="row non-slide-sponsors">
    <% loop $SponsorsList %>
            <div class="sponsor">
                <% if $ElementLink.LinkURL %><a href="$ElementLink.LinkURL" title="Go to $Title.ATT"><% end_if %>
                <% if $Image %>
                    <img src="$Image.Pad(576,576).URL" class="img-fluid">
                <% else %>
                    $Title
                <% end_if %>
                <% if $ElementLink.LinkURL %></a><% end_if %>
            </div>
        <% if $MultipleOf(3,1) %>
            </div>
            <div class="row non-slide-sponsors">
        <% end_if %>
    <% end_loop %>
    </div>
<% end_if %>
