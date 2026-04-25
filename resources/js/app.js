import './bootstrap';
import { createApp, h } from 'vue';
import LoginPage from './pages/auth/LoginPage.vue';
import RegisterPage from './pages/auth/RegisterPage.vue';
import ChangePasswordPage from './pages/auth/ChangePasswordPage.vue';
import HomePage from './pages/HomePage.vue';
import ProfilePage from './pages/ProfilePage.vue';
import DashboardPage from './pages/DashboardPage.vue';
import StudyHomePage from './pages/StudyHomePage.vue';
import FlashcardsLauncherPage from './pages/FlashcardsLauncherPage.vue';
import PendingApprovalPage from './pages/PendingApprovalPage.vue';
import BookmarksPage from './pages/BookmarksPage.vue';
import JlptLevelsPage from './pages/JlptLevelsPage.vue';
import JlptLevelsAdminPage from './pages/admin/JlptLevelsAdminPage.vue';
import JlptLevelFormPage from './pages/admin/JlptLevelFormPage.vue';
import UsersAdminPage from './pages/admin/UsersAdminPage.vue';
import UserFormPage from './pages/admin/UserFormPage.vue';
import UserApprovalsPage from './pages/admin/UserApprovalsPage.vue';
import LessonsPage from './pages/LessonsPage.vue';
import LessonDetailPage from './pages/LessonDetailPage.vue';
import LessonsAdminPage from './pages/admin/LessonsAdminPage.vue';
import LessonFormPage from './pages/admin/LessonFormPage.vue';
import VocabularyPage from './pages/VocabularyPage.vue';
import VocabularyDetailPage from './pages/VocabularyDetailPage.vue';
import VocabularyFlashcardsPage from './pages/VocabularyFlashcardsPage.vue';
import VocabularyAdminPage from './pages/admin/VocabularyAdminPage.vue';
import VocabularyFormPage from './pages/admin/VocabularyFormPage.vue';
import AdminDashboardPage from './pages/admin/AdminDashboardPage.vue';
import SourcesAdminPage from './pages/admin/SourcesAdminPage.vue';
import SourceFormPage from './pages/admin/SourceFormPage.vue';
import KanjiPage from './pages/KanjiPage.vue';
import KanjiLaunchPage from './pages/KanjiLaunchPage.vue';
import KanjiDetailPage from './pages/KanjiDetailPage.vue';
import KanjiFlashcardsPage from './pages/KanjiFlashcardsPage.vue';
import ExampleWordFlashcardsPage from './pages/ExampleWordFlashcardsPage.vue';
import KanjiAdminPage from './pages/admin/KanjiAdminPage.vue';
import KanjiFormPage from './pages/admin/KanjiFormPage.vue';
import ExampleWordsAdminPage from './pages/admin/ExampleWordsAdminPage.vue';
import ExampleWordFormPage from './pages/admin/ExampleWordFormPage.vue';
import KanjiQuizzesPage from './pages/KanjiQuizzesPage.vue';
import KanjiQuizDetailPage from './pages/KanjiQuizDetailPage.vue';
import KanjiQuizTakePage from './pages/KanjiQuizTakePage.vue';
import KanjiQuizResultPage from './pages/KanjiQuizResultPage.vue';

const pages = {
    home: HomePage,
    login: LoginPage,
    register: RegisterPage,
    profile: ProfilePage,
    'change-password': ChangePasswordPage,
    dashboard: DashboardPage,
    'study-home': StudyHomePage,
    'flashcards-launcher': FlashcardsLauncherPage,
    'pending-approval': PendingApprovalPage,
    bookmarks: BookmarksPage,
    'jlpt-levels': JlptLevelsPage,
    'admin-jlpt-levels': JlptLevelsAdminPage,
    'admin-jlpt-level-form': JlptLevelFormPage,
    'admin-users': UsersAdminPage,
    'admin-user-form': UserFormPage,
    'admin-user-approvals': UserApprovalsPage,
    'admin-dashboard': AdminDashboardPage,
    'admin-sources': SourcesAdminPage,
    'admin-source-form': SourceFormPage,
    lessons: LessonsPage,
    'lesson-detail': LessonDetailPage,
    'admin-lessons': LessonsAdminPage,
    'admin-lesson-form': LessonFormPage,
    vocabulary: VocabularyPage,
    'vocabulary-detail': VocabularyDetailPage,
    'vocabulary-flashcards': VocabularyFlashcardsPage,
    'admin-vocabulary': VocabularyAdminPage,
    'admin-vocabulary-form': VocabularyFormPage,
    kanji: KanjiPage,
    'kanji-launch': KanjiLaunchPage,
    'kanji-detail': KanjiDetailPage,
    'kanji-flashcards': KanjiFlashcardsPage,
    'example-word-flashcards': ExampleWordFlashcardsPage,
    'admin-kanji': KanjiAdminPage,
    'admin-kanji-form': KanjiFormPage,
    'admin-example-words': ExampleWordsAdminPage,
    'admin-example-word-form': ExampleWordFormPage,
    'kanji-quizzes': KanjiQuizzesPage,
    'kanji-quiz-detail': KanjiQuizDetailPage,
    'kanji-quiz-take': KanjiQuizTakePage,
    'kanji-quiz-result': KanjiQuizResultPage,
};

const appElement = document.getElementById('app');
const appDataElement = document.getElementById('app-data');

if (appElement && appDataElement) {
    const { component, props } = JSON.parse(appDataElement.textContent);
    const page = pages[component];

    if (page) {
        createApp({
            render: () => h(page, props),
        }).mount(appElement);
    }
}
