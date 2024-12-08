<script setup>
import { Link } from "@inertiajs/vue3";
defineProps({
    filter: String,
});
</script>

<template>
    <div class="filter-container">
        <ul class="nav nav-pills flex-column">
            <li class="nav-item">
                <Link
                    class="nav-link filter-item"
                    :class="{ active: filter === 'latest' }"
                    href="/?filter=latest"
                >
                    <i class="fas fa-clock me-2"></i> Latest
                </Link>
            </li>
            <li class="nav-item">
                <Link
                    class="nav-link filter-item"
                    :class="{ active: filter === 'unanswered' }"
                    href="/?filter=unanswered"
                >
                    <i class="fas fa-question-circle me-2"></i> Unanswered
                </Link>
            </li>
            <li class="nav-item">
                <Link
                    class="nav-link filter-item"
                    :class="{ active: filter === 'scored' }"
                    href="/?filter=scored"
                >
                    <i class="fas fa-star me-2"></i> Scored
                </Link>
            </li>
            <li class="nav-item">
                <Link
                    class="nav-link filter-item"
                    :class="{ active: filter === 'most_answered' }"
                    href="/?filter=most_answered"
                >
                    <i class="fas fa-comment-dots me-2"></i> Most Answered
                </Link>
            </li>
            <li class="nav-item" v-if="$page.props.user">
                <Link
                    class="nav-link filter-item"
                    :class="{ active: filter === 'mine' }"
                    href="/?filter=mine"
                >
                    <i class="fas fa-user me-2"></i> Mine
                </Link>
            </li>
        </ul>
    </div>
</template>

<style scoped>
.filter-container {
    background: #fff; /* Solid, clean background */
    border-radius: 12px;
    padding: 20px;
    max-width: 280px;
    margin: 20px auto;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); /* Larger shadow for elegance */
    transition: all 0.3s ease;
    border: 1px solid #f0f0f0; /* Subtle border for definition */
}

.nav-pills {
    list-style: none;
    padding-left: 0;
}

.nav-link {
    border-radius: 8px;
    padding: 14px 18px;
    font-size: 1rem; /* Balanced text size for clarity */
    color: #4a4a4a; /* Soft, neutral text color */
    font-weight: 500;
    transition: background-color 0.3s, color 0.3s, transform 0.3s ease,
        box-shadow 0.3s ease;
    display: flex;
    align-items: center;
}

.nav-link:hover,
.nav-link.active {
    background-color: #007bff;
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 123, 255, 0.4);
}

.filter-item {
    margin-bottom: 10px;
}

.nav-link i {
    font-size: 1.2rem;
}

.nav-item {
    margin-bottom: 10px;
}

.nav-link.active {
    background-color: #0056b3;
    color: #fff;
    box-shadow: 0 4px 12px rgba(0, 86, 179, 0.3);
}

.nav-link:hover {
    background-color: #0056b3;
    color: #fff;
}
</style>
