<template>
    <footer class="mt-40 absolute bottom-4 left-0 w-full px-24">
        <ul class="home-links flex">
            <li class="mr-2"><a href="https://github.com/osvaldoM" target="_blank" rel="noopener">GitHub</a></li>
            <li class="mr-2"><a href="https://twitter.com/impurefunction" target="_blank" rel="noopener">Twitter</a></li>
            <li class="mr-2"><a href="https://stackoverflow.com/users/story/4043487" target="_blank" rel="noopener">Stackoverflow</a></li>
            <li class="mr-2">
                <a href="https://docs.google.com/document/d/1F8QXk3HaH0zGRcebRWAYwowFziFeIJcy7rnZuvNBXp8/edit?usp=sharing" target="_blank" rel="noopener">
                    Resume</a>
            </li>
            <li class="ml-auto"><span class=""> copyright@{{ currentYear }}</span></li>
        </ul>
    </footer>
</template>

<script>
export default {
  data() {
    return {
      currentYear: new Date().getFullYear(),
    };
  },
};
</script>
