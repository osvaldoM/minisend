<template>
    <div>
        <h1 id="minisend">Minisend</h1>
        <p>A knock-off of <a href="mailersend.com/">MailerSend</a> Built with laravel, vue and little bit of passion.</p>
        <p><img src="https://i.postimg.cc/ZRNffJnn/Minisend-Google-Chrome-504.jpg" alt="home screen">
            <img src="https://i.postimg.cc/HLVvywCQ/Minisend-Google-Chrome-505.jpg" alt="Email details screen">
            <img src="https://i.postimg.cc/6QgjL89F/Minisend-Google-Chrome-506.jpg" alt="Emails to recipient screen">
            <img src="https://i.postimg.cc/Z5fDnfXb/Minisend-Google-Chrome-507.jpg" alt="Add email screen"></p>
        <h1 id="getting-started">Getting started</h1>
        <h2 id="installation">Installation</h2>
        <p>Please check the official laravel installation guide for server requirements before you start. <a href="https://laravel.com/docs/8.x/installation">Official Documentation</a></p>
        <p>Clone the repository</p>
        <pre><code>git <span class="hljs-keyword">clone</span> <span class="hljs-title">git</span>@github.com:osvaldoM/minisend.git
</code></pre><p>Switch to the repo folder</p>
        <pre><code><span class="hljs-built_in">cd</span> minisend
</code></pre><p>Install all the dependencies using composer</p>
        <pre><code>composer <span class="hljs-keyword">install</span>
</code></pre><p>Copy the example env and env.testing files and make the required configuration changes (database, queues and smtp connection)</p>
        <pre><code>cp <span class="hljs-selector-class">.env</span><span class="hljs-selector-class">.example</span> <span class="hljs-selector-class">.env</span> &amp;&amp; <span class="hljs-selector-class">.env</span><span class="hljs-selector-class">.testing</span><span class="hljs-selector-class">.example</span>
</code></pre><p>Generate a new application key</p>
        <pre><code>php artisan key:<span class="hljs-keyword">generate</span>
</code></pre><p>Run the database migrations (<strong>Set the database connection in .env before migrating</strong>)</p>
        <pre><code><span class="hljs-attribute">php artisan migrate</span>
</code></pre><p>Populate the database with seed data with relationships which includes emails, statuses, attachments, etc</p>
        <pre><code><span class="hljs-selector-tag">php</span> <span class="hljs-selector-tag">artisan</span> <span class="hljs-selector-tag">db</span><span class="hljs-selector-pseudo">:seed</span>
</code></pre><p>Start the local development server</p>
        <pre><code>php artisan serve <span class="hljs-comment">--port=8000</span>
</code></pre><p>You can now access the server at <a href="http://localhost:8000">http://localhost:8000</a></p>
        <h2 id="login-details">Login details</h2>
        <p>API/User authentication is not required</p>
        <p>csrf token is not required</p>
        <h2 id="database-seeding">Database seeding</h2>
        <h1 id="testing-api">Testing API</h1>
        <p>To test the laravel backend api</p>
        <pre><code>php artisan test <span class="hljs-comment">--parallel</span>
</code></pre><p>Or if you have phpunit installed globally</p>
        <pre><code><span class="hljs-attribute">phpunit</span>
</code></pre><hr>
        <h1 id="code-overview">Code overview</h1>

    </div>
</template>

<script>
export default {
};
</script>

<style scoped>

</style>
