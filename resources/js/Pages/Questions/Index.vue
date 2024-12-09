<template>
    <AppLayout>
        <div class="container mx-auto px-4 py-8">
            <div class="row">
                <!-- Kolom Kiri: Pertanyaan -->
                <div class="col-md-9">
                    <div class="d-flex items-center justify-between mb-4">
                        <h1 class="text-3xl font-semibold text-gray-600">
                            All Questions
                        </h1>
                    </div>

                    <div
                        class="card shadow-lg rounded-lg bg-white overflow-hidden"
                    >
                        <ul class="list-group list-group-flush">
                            <QuestionSummary
                                v-for="question in questions.data"
                                :key="question.id"
                                :question="question"
                                @edit="editQuestion"
                                @remove="removeQuestion"
                            />
                        </ul>
                    </div>

                    <!-- Pagination -->
                    <Pagination :meta="questions.meta" class="mt-6" />
                </div>

                <!-- Kolom Kanan: Sidebar -->
                <div class="col-md-3">
                    <div class="d-grid">
                        <button
                            class="btn btn-primary bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-300 ease-in-out"
                            @click.prevent="askQuestion"
                        >
                            Ask Question
                        </button>
                    </div>

                    <!-- Filter -->
                    <QuestionFilter :filter="filter" />

                    <!-- Related Tags -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 mt-6">
                            Related Tags
                        </h2>
                        <ul class="tags-list mt-4">
                            <li v-for="tag in tags" :key="tag">
                                <a
                                    href="#"
                                    class="tag bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-2 px-4 rounded-full transition duration-300 ease-in-out"
                                >
                                    {{ tag }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <Modal
            id="question-modal"
            :title="modalTitle"
            size="large"
            scrollable
            @hidden="editing = false"
        >
            <component
                :is="editing ? EditQuestionForm : CreateQuestionForm"
                :question="question"
                @success="hideModal"
            />
        </Modal>
    </AppLayout>

    <Head title="All Questions" />
</template>

<script setup>
import { reactive, ref } from "vue";
import { Head, router } from "@inertiajs/vue3";
import AppLayout from "../../Layouts/AppLayout.vue";
import QuestionSummary from "../../Components/Question/QuestionSummary.vue";
import Pagination from "../../Components/Pagination.vue";
import CreateQuestionForm from "../../Components/Question/CreateQuestionForm.vue";
import EditQuestionForm from "../../Components/Question/EditQuestionForm.vue";
import QuestionFilter from "../../Components/Question/QuestionFilter.vue";
import useModal from "../../Composable/useModal";

const { showModal, hideModal, modalTitle, Modal } = useModal("#question-modal");

defineProps({
    questions: {
        type: Object,
        required: true,
    },
    filter: String,
});

const tags = [
    "Javascript",
    "JQuery",
    "Vue.js",
    "React.js",
    "Inertia.js",
    "PHP",
    "Laravel",
    "Bootstrap",
    "Tailwind",
];

const question = reactive({
    id: null,
    title: null,
    body: null,
});

const editing = ref(false);

const editQuestion = (payload) => {
    editing.value = true;
    modalTitle.value = "Edit Question";

    question.id = payload.id;
    question.title = payload.title;
    question.body = payload.body;
    showModal();
};

const askQuestion = () => {
    editing.value = false;
    modalTitle.value = "Ask Question";
    showModal();
};

const removeQuestion = (payload) => {
    if (confirm("Are you sure?")) {
        router.delete(route("questions.destroy", payload.id), {
            preserveScroll: true,
        });
    }
};
</script>

<style scoped>
/* Card Styling */
.card {
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    background-color: #fff;
}

.card .list-group-item {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid #eee;
}

/* Button Styling */
button {
    width: 100%;
    font-size: 16px;
}

button:hover {
    background-color: #007bff;
}

/* Tags Styling */
.tag {
    padding: 0.5rem 1rem;
    margin-bottom: 0.5rem;
    border-radius: 9999px;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.tag:hover {
    background-color: #3490dc;
    color: white;
    transform: scale(1.05);
}
</style>
