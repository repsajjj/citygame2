<div class="top-bar">
    <div class="top-bar-title">
      <span data-responsive-toggle="responsive-menu" data-hide-for="medium">
        <button class="menu-icon dark" type="button" data-toggle></button>
      </span>
      <strong><a href="{{ path_for('home') }}"><img src="/img/images/citygame2.svg" alt="Citygame"></a></strong>
    </div>
  <div id="responsive-menu">
    <div class="top-bar-left">
      <ul class="dropdown vertical medium-horizontal menu" data-dropdown-menu>
        <li><a href="{{ path_for('home') }}">Home</a></li>
        <li><a href="{{ path_for('booking') }}">Booking</a></li>
        <li><a href="{{ path_for('scores') }}">Scores</a></li>
      </ul>
    </div>
    <div class="top-bar-right">
        <ul class="dropdown vertical medium-horizontal menu" data-dropdown-menu>
            {% if(key.isValid) %}
            {% if(key.getType=="master") %}
            <li><a href="{{ path_for('master') }}">Controlpanel</a></li>
            {% elseif(key.getType=="player") %}
            <li><a href="{{ path_for('player') }}">Upload</a></li>
            {% else %}
            <li>Session not found</li>
            {% endif %}
            <li><a href="{{ path_for('logout') }}">Logout</a></li>
            {% else %}
            <li><a href="{{ path_for('login') }}">Login</a></li>
            {% endif %}
        </ul>
    </div>
  </div>
</div>
