<div class="fixed contain-to-grid">
    <nav class="top-bar" data-topbar role="navigation">
        <ul class="title-area">
            <li class="name">
                <h1><a href="{{ path_for('home') }}"><img src="/img/images/citygame.svg" alt="Citygame"></a></h1>
            </li>
            <!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
            <li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
        </ul>
        <section class="top-bar-section">
            <!-- Right Nav Section -->
            <ul class="right">
                {% if(key.isValid) %}
                {% if(key.getType=="master") %}
                <li><a href="{{ path_for('master') }}">Controlpanel</a></li>
                {% elseif(key.getType=="player") %}
                <li><a href="{{ path_for('player') }}">Upload</a></li>
                {% else %}
                <li>Session not found</li>
                {% endif %}
                <li class="divider"></li>
                <li><a href="{{ path_for('logout') }}">Logout</a></li>
                {% else %}
                <li><a href="{{ path_for('login') }}">Log In</a></li>
                {% endif %}
            </ul>

            <!-- Left Nav Section -->
            <ul class="left">
                <li class="active"><a href="{{ path_for('home') }}">Home</a></li>
                <li><a href="{{ path_for('booking') }}">Booking</a></li>
                <li><a href="{{ path_for('scores') }}">Scores</a></li>
            </ul>
        </section>

    </nav>
</div>
