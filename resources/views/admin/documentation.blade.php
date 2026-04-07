@extends('layouts.admin')

<head>
    <title>Documentation interne - Calan'Couleurs</title>
</head>

@section('content')
    <main class="flex-1 overflow-y-auto bg-gray-50">
        <div class="flex flex-col lg:flex-row h-full overflow-hidden gap-4">

            <aside class="m-6 mr-0 w-full bg-white rounded-lg shadow-sm lg:w-80 shrink-0 overflow-auto">
                <div class="px-6 py-4">
                    <p class="text-xs font-semibold tracking-widest text-slate-500 uppercase mb-3">Sommaire</p>

                    <nav class="space-y-2">
                        <button data-target="section1"
                            class="doc-link block w-full text-left px-2 py-2 text-sm text-gray-700 rounded hover:bg-gray-100">I.
                            Introduction</button>

                        <button data-target="section1-1"
                            class="doc-link block w-full text-left px-4 py-2 text-sm text-gray-700 rounded hover:bg-gray-100">
                            I.1 Objectif de la documentation
                        </button>

                        <button data-target="section1-2"
                            class="doc-link block w-full text-left px-4 py-2 text-sm text-gray-700 rounded hover:bg-gray-100">
                            I.2 Public concerné
                        </button>

                        <button data-target="section1-3"
                            class="doc-link block w-full text-left px-4 py-2 text-sm text-gray-700 rounded hover:bg-gray-100">
                            I.3 Périmètre fonctionnel
                        </button>

                        <button data-target="section2"
                            class="doc-link block w-full text-left px-2 py-2 text-sm text-gray-700 rounded hover:bg-gray-100">
                            II. Accès et sécurité
                        </button>

                        <button data-target="section2-1"
                            class="doc-link block w-full text-left px-4 py-2 text-sm text-gray-700 rounded hover:bg-gray-100">
                            II.1 Connexion & vérification d'e-mail
                        </button>

                        <button data-target="section2-2"
                            class="doc-link block w-full text-left px-4 py-2 text-sm text-gray-700 rounded hover:bg-gray-100">
                            II.2 Gestion des comptes
                        </button>

                        <button data-target="section3"
                            class="doc-link block w-full text-left px-2 py-2 text-sm text-gray-700 rounded hover:bg-gray-100">
                            III. Back-Office
                        </button>

                        <button data-target="section3-1"
                            class="doc-link block w-full text-left px-4 py-2 text-sm text-gray-700 rounded hover:bg-gray-100">
                            III.1 Gestion des éditions
                        </button>

                        <button data-target="section3-2"
                            class="doc-link block w-full text-left px-4 py-2 text-sm text-gray-700 rounded hover:bg-gray-100">
                            III.2 Gestion des artistes
                        </button>

                        <button data-target="section3-3"
                            class="doc-link block w-full text-left px-4 py-2 text-sm text-gray-700 rounded hover:bg-gray-100">
                            III.3 Gestion des stands
                        </button>

                        <button data-target="section3-4"
                            class="doc-link block w-full text-left px-4 py-2 text-sm text-gray-700 rounded hover:bg-gray-100">
                            III.4 Gestion des utilisateurs
                        </button>

                        <button data-target="section3-5"
                            class="doc-link block w-full text-left px-4 py-2 text-sm text-gray-700 rounded hover:bg-gray-100">
                            III.5 Gestion des FAQs
                        </button>

                        <button data-target="section4"
                            class="doc-link block w-full text-left px-2 py-2 text-sm text-gray-700 rounded hover:bg-gray-100">
                            IV. Calan'Boutique
                        </button>
                    </nav>
                </div>
            </aside>

            <section id="doc-content" class="m-6 ml-0 space-y-6 flex-1 overflow-auto">
                <article id="section1" class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="px-6 py-4 rounded-t-lg"
                        style="background: linear-gradient(90deg, #9333ea 0%, #ec4899 100%);">
                        <p class="text-xs uppercase tracking-widest text-white/80">Partie I</p>
                        <h2 class="text-2xl md:text-3xl font-bold text-white">Introduction</h2>
                    </div>
                    <div class="p-6">
                        <p class="text-slate-700 leading-relaxed">
                            Cette documentation interne centralise les informations utiles pour comprendre,
                            utiliser et faire évoluer le back-office Calan'Couleurs.
                        </p>
                    </div>
                </article>

                <article id="section1-1" class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
                        <p class="text-xs uppercase tracking-widest text-slate-500">Partie I.1</p>
                        <h3 class="text-xl md:text-2xl font-bold text-slate-900">Objectif de la documentation</h3>
                    </div>
                    <div class="p-6">
                        <p class="text-slate-700 leading-relaxed">
                            L’objectif est de fournir un guide clair pour toute l'équipe de l'association :
                            accès aux fonctionnalités, bonnes pratiques, conventions générales et repères
                            techniques essentiels.
                        </p>
                    </div>
                </article>

                <article id="section1-2" class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
                        <p class="text-xs uppercase tracking-widest text-slate-500">Partie I.2</p>
                        <h3 class="text-xl md:text-2xl font-bold text-slate-900">Public concerné</h3>
                    </div>
                    <div class="p-6">
                        <p class="text-slate-700 leading-relaxed">
                            Cette documentation s’adresse à tous les membres de l’association, en particulier
                            ceux qui interagissent avec le back-office : administrateurs, responsables de
                            contenu et bénévoles chargés de la mise à jour des informations.
                        </p>
                    </div>
                </article>

                <article id="section1-3" class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
                        <p class="text-xs uppercase tracking-widest text-slate-500">Partie I.3</p>
                        <h3 class="text-xl md:text-2xl font-bold text-slate-900">Périmètre fonctionnel</h3>
                    </div>
                    <div class="p-6">
                        <p class="text-slate-700 leading-relaxed">
                            La documentation couvre les fonctionnalités du back-office liées à la gestion des
                            éditions, des artistes, des performances, des FAQs, des utilisateurs ainsi que
                            les aspects liés à la boutique en ligne avec l’intégration de HelloAsso.
                        </p>
                    </div>
                </article>

                <article id="section2" class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="px-6 py-4 rounded-t-lg"
                        style="background: linear-gradient(90deg, #9333ea 0%, #ec4899 100%);">
                        <p class="text-xs uppercase tracking-widest text-white/80">Partie II</p>
                        <h2 class="text-2xl md:text-3xl font-bold text-white">Accès & Sécurité</h2>
                    </div>
                    <div class="p-6">
                        <p class="text-slate-700 leading-relaxed">
                            En ce qui concerne les accès et la sécurité, il est essentiel de suivre les bonnes pratiques
                            pour protéger les données de l'association et garantir un usage sécurisé du back-office. Voici
                            les points clés à respecter :
                        <ul class="list-disc list-inside mt-4 space-y-2">
                            <li><strong>Gestion des utilisateurs :</strong> Seuls les membres autorisés doivent avoir accès
                                au back-office. Les rôles et permissions doivent être définis clairement pour limiter les
                                actions possibles en fonction des responsabilités de chacun.</li>
                            <li><strong>Authentification :</strong> Utiliser des mots de passe forts et uniques pour chaque
                                compte utilisateur. Une authentification à deux facteurs (2FA) sera mise en place si
                                possible pour renforcer la sécurité des
                                comptes.</li>
                            <li><strong>Surveillance des accès :</strong> Un journal concernant l'historique des actions est
                                présent pour suivre les activités des utilisateurs et détecter toute anomalie.</li>
                            <li><strong>Formation et sensibilisation :</strong> Assurer que tous les utilisateurs du
                                back-office sont formés aux bonnes pratiques de sécurité et comprennent l'importance de
                                protéger les données de l'association.</li>
                        </ul>
                        </p>
                    </div>
                </article>

                <article id="section2-1" class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
                        <p class="text-xs uppercase tracking-widest text-slate-500">Partie II.1</p>
                        <h3 class="text-xl md:text-2xl font-bold text-slate-900">Connexion</h3>
                    </div>

                    <div class="p-6 space-y-8">
                        <div class="space-y-3">
                            <p class="text-slate-700 leading-relaxed">
                                Cette section explique comment accéder au back-office pour la première fois
                                et comment se connecter ensuite de manière sécurisée.
                            </p>

                            <div class="rounded-lg border border-blue-200 bg-blue-50 p-4">
                                <p class="text-sm font-semibold text-blue-900">Prérequis</p>
                                <ul class="mt-2 list-disc list-inside space-y-1 text-sm text-blue-800">
                                    <li>Disposer d’un compte créé par un administrateur</li>
                                    <li>Connaître son identifiant et l’adresse e-mail transmise à l’équipe</li>
                                    <li>Avoir accès à sa boîte mail pour la vérification du compte</li>
                                </ul>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div class="space-y-2">
                                <h4 class="text-lg font-semibold text-slate-900">Étape 1. Accéder à la page de connexion
                                </h4>
                                <p class="text-slate-700 leading-relaxed">
                                    Rendez-vous sur la page d’administration en utilisant le lien fourni dans le footer du
                                    site public ou en accédant directement à l’URL dédiée (ex :
                                    https://calancouleurs.fr/admin).
                                </p>

                                <figure class="overflow-hidden rounded-lg border border-slate-200 bg-white">
                                    <img src="{{ asset('img/docs/connexion/01-acces-menu-connexion.png') }}"
                                        alt="Accès à la page de connexion depuis le footer du site public"
                                        class="doc-zoomable w-full object-cover cursor-zoom-in">
                                    <figcaption class="px-4 py-3 text-sm text-slate-600 bg-slate-50">
                                        Accès à la page de connexion depuis le footer du site public.
                                    </figcaption>
                                </figure>
                            </div>

                            <div class="space-y-2">
                                <h4 class="text-lg font-semibold text-slate-900">Étape 2. Première connexion</h4>
                                <p class="text-slate-700 leading-relaxed">
                                    Lors de la première connexion, cliquez sur “Première connexion ?”.
                                </p>

                                <figure class="overflow-hidden rounded-lg border border-slate-200 bg-white">
                                    <img src="{{ asset('img/docs/connexion/02-premiere-connexion.png') }}"
                                        alt="Lien première connexion et formulaire d'initialisation"
                                        class="doc-zoomable max-w-2xl mx-auto rounded object-cover cursor-zoom-in">
                                    <figcaption class="px-4 py-3 text-sm text-slate-600 bg-slate-50">
                                        Formulaire de connexion avec le lien pour la première connexion.
                                    </figcaption>
                                </figure>
                            </div>

                            <div class="space-y-2">
                                <h4 class="text-lg font-semibold text-slate-900">Étape 3. Initialiser son compte</h4>
                                <p class="text-slate-700 leading-relaxed">
                                    Les informations saisies doivent correspondre exactement à celles enregistrées
                                    par l’administrateur. En cas d’erreur, l’initialisation sera refusée.
                                </p>

                                <figure class="overflow-hidden rounded-lg border border-slate-200 bg-white">
                                    <img src="{{ asset('img/docs/connexion/03-initialisation-compte.png') }}"
                                        alt="Exemple de saisie des informations de vérification"
                                        class="doc-zoomable max-w-2xl mx-auto rounded object-cover cursor-zoom-in">
                                    <figcaption class="px-4 py-3 text-sm text-slate-600 bg-slate-50">
                                        Formulaire d'initialisation du compte.
                                    </figcaption>
                                </figure>
                            </div>

                            <div class="space-y-2">
                                <h4 class="text-lg font-semibold text-slate-900">Étape 4. Confirmer son initialisation</h4>
                                <p class="text-slate-700 leading-relaxed">
                                    Une fois le mot de passe défini, un e-mail de vérification est envoyé.
                                    Le compte ne doit être utilisé qu’après validation de cette adresse.
                                </p>

                                <figure class="overflow-hidden rounded-lg border border-slate-200 bg-white">
                                    <img src="{{ asset('img/docs/connexion/04-apres-initialisation.png') }}"
                                        alt="Message invitant à vérifier l'adresse e-mail"
                                        class="doc-zoomable max-w-2xl mx-auto rounded object-cover cursor-zoom-in">
                                    <figcaption class="px-4 py-3 text-sm text-slate-600 bg-slate-50">
                                        Message affiché après l'initialisation du compte, invitant à vérifier l'adresse
                                        e-mail.
                                    </figcaption>
                                </figure>
                            </div>

                            <div class="space-y-2">
                                <h4 class="text-lg font-semibold text-slate-900">Étape 5. Vérifier son adresse e-mail</h4>
                                <p class="text-slate-700 leading-relaxed">
                                    Le lien de vérification dans l’e-mail doit être cliqué pour activer le compte. Après
                                    validation, vous serez automatiquement redirigé vers le formulaire de connexion au
                                    back-office.
                                </p>

                                <figure class="overflow-hidden rounded-lg border border-slate-200 bg-white">
                                    <img src="{{ asset('img/docs/connexion/05-verification-email.png') }}"
                                        alt="E-mail de vérification envoyé avec le lien d'activation du compte"
                                        class="doc-zoomable w-full object-cover cursor-zoom-in">
                                    <figcaption class="px-4 py-3 text-sm text-slate-600 bg-slate-50">
                                        E-mail de vérification envoyé.
                                    </figcaption>
                                </figure>
                            </div>

                            <div class="space-y-2">
                                <h4 class="text-lg font-semibold text-slate-900">Étape 6. Accès au back-office autorisé
                                </h4>
                                <p class="text-slate-700 leading-relaxed">
                                    Après validation de l’adresse e-mail, le compte est activé et vous pouvez accéder au
                                    back-office, vous pouvez alors vous connecter avec vos identifiants. Vous serez redirigé
                                    vers la page d’accueil
                                    du back-office où vous pourrez commencer à gérer les différentes sections selon vos
                                    permissions.
                                </p>

                                <figure class="overflow-hidden rounded-lg border border-slate-200 bg-white">
                                    <img src="{{ asset('img/docs/connexion/06-acces-backoffice.png') }}"
                                        alt="Accès au back-office après vérification de l'adresse e-mail"
                                        class="doc-zoomable w-full object-cover cursor-zoom-in">
                                    <figcaption class="px-4 py-3 text-sm text-slate-600 bg-slate-50">
                                        Accès au back-office après vérification de l'adresse e-mail.
                                    </figcaption>
                                </figure>
                            </div>
                        </div>

                        <div class="rounded-lg border border-amber-200 bg-amber-50 p-4">
                            <p class="text-sm font-semibold text-amber-900">Points d’attention</p>
                            <ul class="mt-2 list-disc list-inside space-y-1 text-sm text-amber-800">
                                <li>Ne jamais partager son mot de passe</li>
                                <li>Utiliser un mot de passe unique et robuste</li>
                                <li>Vérifier que l’adresse e-mail utilisée est bien celle communiquée à l’administration
                                </li>
                                <li>En cas de blocage, contacter un super-administrateur</li>
                            </ul>
                        </div>
                    </div>
                </article>

                <article id="section2-2" class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
                        <p class="text-xs uppercase tracking-widest text-slate-500">Partie II.2</p>
                        <h3 class="text-xl md:text-2xl font-bold text-slate-900">Gestion des comptes</h3>
                    </div>
                    <div class="p-6 space-y-8">
                        <div class="space-y-3">
                            <p class="text-slate-700 leading-relaxed">
                                La gestion des comptes utilisateurs est une responsabilité clé pour assurer la sécurité et
                                le bon fonctionnement du back-office. Voici les principales actions liées à la gestion des
                                comptes :
                            </p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                                <!-- Création de comptes -->
                                <div class="rounded-lg border border-purple-200 bg-purple-50 p-5">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <i class="fa-solid fa-plus w-6 h-6 text-purple-600"></i>
                                        </div>
                                        <div class="ml-3">
                                            <h4 class="text-sm font-semibold text-purple-900">Création de comptes</h4>
                                            <p class="mt-1 text-sm text-purple-700">
                                                Seule l'équipe de développeurs peut créer de nouveaux comptes sur demande
                                                des présidents.
                                                Fournir des informations précises et communiquer les identifiants à
                                                l'utilisateur.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Gestion des rôles -->
                                <div class="rounded-lg border border-blue-200 bg-blue-50 p-5">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <i class="fa-solid fa-circle-info w-6 h-6 text-blue-600"></i>
                                        </div>
                                        <div class="ml-3">
                                            <h4 class="text-sm font-semibold text-blue-900">Gestion des rôles</h4>
                                            <p class="mt-1 text-sm text-blue-700">
                                                Attribuer les rôles appropriés à chaque utilisateur selon ses
                                                responsabilités au sein de l'association.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Désactivation et suppression -->
                                <div class="rounded-lg border border-red-200 bg-red-50 p-5 md:col-span-2">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <i class="fa-solid fa-circle-exclamation w-6 h-6 text-red-600"></i>
                                        </div>
                                        <div class="ml-3 flex-1">
                                            <h4 class="text-sm font-semibold text-red-900">Désactivation et suppression
                                            </h4>
                                            <p class="mt-1 text-sm text-red-700 mb-3">
                                                En cas de départ ou de compromission, désactiver ou supprimer le compte.
                                                La hiérarchisation des rôles s'applique :
                                            </p>
                                            <div class="space-y-2 text-sm text-red-800">
                                                <div class="flex items-center">
                                                    <span class="inline-block w-2 h-2 bg-red-600 rounded-full mr-2"></span>
                                                    <span><strong>Super-admin</strong> : peut désactiver tout type de
                                                        compte</span>
                                                </div>
                                                <div class="flex items-center">
                                                    <span class="inline-block w-2 h-2 bg-red-600 rounded-full mr-2"></span>
                                                    <span><strong>Admin</strong> : peut désactiver uniquement les comptes
                                                        "editor"</span>
                                                </div>
                                                <div class="flex items-center">
                                                    <span class="inline-block w-2 h-2 bg-red-600 rounded-full mr-2"></span>
                                                    <span><strong>Editor</strong> : ne peut désactiver aucun compte</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <ul class="list-disc list-inside mt-4 space-y-2">
                                <li><strong>Création de comptes :</strong> Seule l'équipe de développeurs peut créer de
                                    nouveaux comptes uniquement sous la demande des présidents de l'association. Lors de la
                                    création, il est important de fournir des informations
                                    précises et de communiquer les identifiants à l’utilisateur concerné.</li>
                                <li><strong>Modification des comptes :</strong> Les administrateurs peuvent mettre à jour
                                    les
                                    informations des utilisateurs, notamment en cas de changement de rôle ou d’adresse
                                    e-mail. Cependant, il est crucial de ne pas modifier l’adresse e-mail sans en informer
                                    l’utilisateur, car elle est utilisée pour la vérification du compte.</li>
                                <li><strong>Gestion des rôles :</strong> Il est important d’attribuer les rôles appropriés à
                                    chaque utilisateur en fonction de ses responsabilités au sein de l’association.</li>
                                <li><strong>Désactivation et suppression :</strong> En cas de départ d’un membre ou de
                                    compromission d’un compte, il est possible de désactiver ou supprimer le compte pour
                                    empêcher tout accès non autorisé. Mais il faut prendre en compte la hiérarchisation
                                    des rôles. Un "super-admin" peut désactiver tout type de compte. Un "admin" peut
                                    désactiver uniquement les comptes "editor". Un compte "editor" ne peut désactiver aucun
                                    compte.</li>
                            </ul> --}}
                        </div>
                </article>

                <article id="section3" class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="px-6 py-4 rounded-t-lg"
                        style="background: linear-gradient(90deg, #9333ea 0%, #ec4899 100%);">
                        <p class="text-xs uppercase tracking-widest text-white/80">Partie III</p>
                        <h2 class="text-2xl md:text-3xl font-bold text-white">Back-Office</h2>
                    </div>
                    <div class="p-6">
                        <p class="text-slate-700 leading-relaxed">
                            Le back-office de Calan'Couleurs est l'outil central pour gérer les différentes éditions du
                            festival, les artistes, les performances, les FAQs, les utilisateurs. Il est conçu pour être
                            intuitif et accessible à tous les membres de l'association
                            ayant des responsabilités de gestion.
                        </p>
                    </div>
                </article>

                <article id="section3-1" class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
                        <p class="text-xs uppercase tracking-widest text-slate-500">Partie III.1</p>
                        <h3 class="text-xl md:text-2xl font-bold text-slate-900">Gestion des éditions</h3>
                    </div>
                    <div class="p-6 space-y-8">
                        <p class="text-slate-700 leading-relaxed">
                            Cette section détaille le parcours complet pour gérer les éditions du festival :
                            accès au module, consultation, création, modification et gestion des performances associées.
                        </p>

                        <div class="space-y-6">
                            <div class="space-y-2">
                                <h4 class="text-lg font-semibold text-slate-900">Accéder à la partie "Éditions"</h4>
                                <p class="text-slate-700 leading-relaxed">
                                    Depuis le menu latéral du back-office, cliquer sur <strong>Éditions</strong> pour
                                    accéder à la gestion des éditions.
                                </p>
                                <figure class="overflow-hidden rounded-lg border border-slate-200 bg-white">
                                    <img src="{{ asset('img/docs/editions/01-acces-menu-editions.png') }}"
                                        alt="Accès à la partie Éditions depuis le menu latéral"
                                        class="doc-zoomable w-full object-cover cursor-zoom-in">
                                    <figcaption class="px-4 py-3 text-sm text-slate-600 bg-slate-50">
                                        Accès à la partie Éditions depuis le menu principal.
                                    </figcaption>
                                </figure>
                            </div>

                            <div class="space-y-2">
                                <h4 class="text-lg font-semibold text-slate-900">Consulter la liste des éditions</h4>
                                <p class="text-slate-700 leading-relaxed">
                                    Sur cette page, vous pouvez consulter la liste des éditions, créer une nouvelle édition
                                    et ouvrir la fiche détaillée d’une édition existante.
                                </p>
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                                    <figure class="overflow-hidden rounded-lg border border-slate-200 bg-white">
                                        <img src="{{ asset('img/docs/editions/02-liste-editions.png') }}"
                                            alt="Liste des éditions avec filtres, création et accès au détail"
                                            class="doc-zoomable max-w-4xl w-full mx-auto h-auto object-contain cursor-zoom-in">
                                        <figcaption class="px-4 py-3 text-sm text-slate-600 bg-slate-50">
                                            Vue d’ensemble des éditions avec filtres et actions.
                                        </figcaption>
                                    </figure>

                                    <figure class="overflow-hidden rounded-lg border border-slate-200 bg-white">
                                        <img src="{{ asset('img/docs/editions/03-ajout-edition.png') }}"
                                            alt="Ajouter une édition du festival"
                                            class="doc-zoomable max-w-4xl w-full mx-auto h-auto object-contain cursor-zoom-in">
                                        <figcaption class="px-4 py-3 text-sm text-slate-600 bg-slate-50">
                                            Formulaire d’ajout d’une nouvelle édition.
                                        </figcaption>
                                    </figure>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <h4 class="text-lg font-semibold text-slate-900">Voir et/ou modifier une édition</h4>
                                <p class="text-slate-700 leading-relaxed">
                                    Sur la page détail d'une édition pour consulter ses informations, vous pouvez facilement
                                    passer en mode modification en cliquant sur le bouton "Modifier".
                                </p>

                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                                    <figure class="overflow-hidden rounded-lg border border-slate-200 bg-white">
                                        <img src="{{ asset('img/docs/editions/04-detail-edition.png') }}"
                                            alt="Fiche détail d'une édition"
                                            class="doc-zoomable w-full h-auto object-contain cursor-zoom-in">
                                        <figcaption class="px-4 py-3 text-sm text-slate-600 bg-slate-50">
                                            Fiche détail de l’édition.
                                        </figcaption>
                                    </figure>

                                    <figure class="overflow-hidden rounded-lg border border-slate-200 bg-white">
                                        <img src="{{ asset('img/docs/editions/05-modification-edition.png') }}"
                                            alt="Passage en mode modification de la fiche édition"
                                            class="doc-zoomable w-full h-auto object-contain cursor-zoom-in">
                                        <figcaption class="px-4 py-3 text-sm text-slate-600 bg-slate-50">
                                            Passage en mode modification de la fiche édition.
                                        </figcaption>
                                    </figure>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <h4 class="text-lg font-semibold text-slate-900">Gérer les performances de
                                    l’édition</h4>
                                <p class="text-slate-700 leading-relaxed">
                                    Depuis la fiche édition, vous pouvez accéder à la gestion des performances puis ajouter
                                    une nouvelle
                                    performance.
                                </p>

                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                                    <figure class="overflow-hidden rounded-lg border border-slate-200 bg-white">
                                        <img src="{{ asset('img/docs/editions/06-gestion-performances.png') }}"
                                            alt="Page de gestion des performances d'une édition"
                                            class="doc-zoomable w-full h-auto object-contain cursor-zoom-in">
                                        <figcaption class="px-4 py-3 text-sm text-slate-600 bg-slate-50">
                                            Lien vers la gestion des performances.
                                        </figcaption>
                                    </figure>

                                    <figure class="overflow-hidden rounded-lg border border-slate-200 bg-white">
                                        <img src="{{ asset('img/docs/editions/07-liste-performances.png') }}"
                                            alt="Page de gestion des performances d'une édition"
                                            class="doc-zoomable w-full h-auto object-contain cursor-zoom-in">
                                        <figcaption class="px-4 py-3 text-sm text-slate-600 bg-slate-50">
                                            Liste et gestion des performances.
                                        </figcaption>
                                    </figure>

                                    <figure class="overflow-hidden rounded-lg border border-slate-200 bg-white">
                                        <img src="{{ asset('img/docs/editions/08-ajout-performance.png') }}"
                                            alt="Formulaire d'ajout de performance"
                                            class="doc-zoomable w-full h-auto object-contain cursor-zoom-in">
                                        <figcaption class="px-4 py-3 text-sm text-slate-600 bg-slate-50">
                                            Formulaire d’ajout d’une performance.
                                        </figcaption>
                                    </figure>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-lg border border-amber-200 bg-amber-50 p-4">
                            <p class="text-sm font-semibold text-amber-900">Points d’attention</p>
                            <ul class="mt-2 list-disc list-inside space-y-1 text-sm text-amber-800">
                                <li>Vérifier les dates et horaires avant de sauvegarder une édition.</li>
                                <li>Contrôler la cohérence du statut et de la visibilité.</li>
                                <li>Ne publier que des performances validées par l’équipe.</li>
                            </ul>
                        </div>
                    </div>
                </article>

                <article id="section3-2" class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
                        <p class="text-xs uppercase tracking-widest text-slate-500">Partie III.2</p>
                        <h3 class="text-xl md:text-2xl font-bold text-slate-900">Gestion des artistes</h3>
                    </div>

                    <div class="p-6 space-y-8">
                        <p class="text-slate-700 leading-relaxed">
                            Cette section explique le parcours complet pour gérer les artistes :
                            accès au module, consultation, création, modification, modification et gestion des performances
                            associées.
                        </p>

                        <div class="space-y-6">
                            <div class="space-y-2">
                                <h4 class="text-lg font-semibold text-slate-900">Accéder à la partie "Artistes"</h4>
                                <p class="text-slate-700 leading-relaxed">
                                    Depuis le menu latéral du back-office, cliquer sur <strong>Artistes</strong> pour
                                    accéder à la gestion des artistes.
                                </p>
                                <figure class="overflow-hidden rounded-lg border border-slate-200 bg-white">
                                    <img src="{{ asset('img/docs/artistes/01-acces-menu-artistes.png') }}"
                                        alt="Accès à la partie Artistes depuis le menu latéral"
                                        class="doc-zoomable w-full h-auto object-contain cursor-zoom-in">
                                    <figcaption class="px-4 py-3 text-sm text-slate-600 bg-slate-50">
                                        Accès à la partie Artistes depuis le menu principal.
                                    </figcaption>
                                </figure>
                            </div>

                            <div class="space-y-2">
                                <h4 class="text-lg font-semibold text-slate-900">Consulter la liste des artistes</h4>
                                <p class="text-slate-700 leading-relaxed">
                                    Sur cette page, vous pouvez consulter la liste des artistes, créer un(e) nouvel(le)
                                    artiste
                                    et ouvrir la fiche détaillée d’un(e) artiste existant(e).
                                </p>
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                                    <figure class="overflow-hidden rounded-lg border border-slate-200 bg-white">
                                        <img src="{{ asset('img/docs/artistes/02-liste-artistes.png') }}"
                                            alt="Liste des artistes avec filtres, création et accès au détail"
                                            class="doc-zoomable max-w-4xl w-full mx-auto h-auto object-contain cursor-zoom-in">
                                        <figcaption class="px-4 py-3 text-sm text-slate-600 bg-slate-50">
                                            Vue d’ensemble des artistes avec filtres et actions.
                                        </figcaption>
                                    </figure>

                                    <figure class="overflow-hidden rounded-lg border border-slate-200 bg-white">
                                        <img src="{{ asset('img/docs/artistes/07-ajout-artiste.png') }}"
                                            alt="Ajouter un(e) artiste"
                                            class="doc-zoomable max-w-4xl w-full mx-auto h-auto object-contain cursor-zoom-in">
                                        <figcaption class="px-4 py-3 text-sm text-slate-600 bg-slate-50">
                                            Formulaire d’ajout d’un(e) nouvel(le) artiste.
                                        </figcaption>
                                    </figure>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <h4 class="text-lg font-semibold text-slate-900">Voir et/ou modifier un(e) artiste</h4>
                                <p class="text-slate-700 leading-relaxed">
                                    Sur la page détail d'un(e) artiste, vous pouvez consulter ses informations et passer en
                                    mode modification en cliquant sur le bouton "Modifier".
                                </p>

                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                                    <figure class="overflow-hidden rounded-lg border border-slate-200 bg-white">
                                        <img src="{{ asset('img/docs/artistes/03-detail-artiste.png') }}"
                                            alt="Fiche détail d'un artiste"
                                            class="doc-zoomable w-full h-auto object-contain cursor-zoom-in">
                                        <figcaption class="px-4 py-3 text-sm text-slate-600 bg-slate-50">
                                            Fiche détail d’un artiste.
                                        </figcaption>
                                    </figure>

                                    <figure class="overflow-hidden rounded-lg border border-slate-200 bg-white">
                                        <img src="{{ asset('img/docs/artistes/04-modification-artiste.png') }}"
                                            alt="Passage en mode modification de la fiche artiste"
                                            class="doc-zoomable w-full h-auto object-contain cursor-zoom-in">
                                        <figcaption class="px-4 py-3 text-sm text-slate-600 bg-slate-50">
                                            Passage en mode modification de la fiche artiste.
                                        </figcaption>
                                    </figure>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <h4 class="text-lg font-semibold text-slate-900">Gérer la partie performances
                                </h4>
                                <p class="text-slate-700 leading-relaxed">
                                    Depuis la fiche artiste, vous pouvez consulter la zone dédiée à ses performances
                                    associées,
                                    puis passer en mode modification pour ajuster ces éléments.
                                </p>

                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                                    <figure class="overflow-hidden rounded-lg border border-slate-200 bg-white">
                                        <img src="{{ asset('img/docs/artistes/05-detail-artiste-performances.png') }}"
                                            alt="Détail artiste centré sur la section performances"
                                            class="doc-zoomable w-full h-auto object-contain cursor-zoom-in">
                                        <figcaption class="px-4 py-3 text-sm text-slate-600 bg-slate-50">
                                            Vue détail centrée sur la section performances.
                                        </figcaption>
                                    </figure>

                                    <figure class="overflow-hidden rounded-lg border border-slate-200 bg-white">
                                        <img src="{{ asset('img/docs/artistes/06-edition-artiste-performances.png') }}"
                                            alt="Passage en mode modification des performances d'un artiste"
                                            class="doc-zoomable w-full h-auto object-contain cursor-zoom-in">
                                        <figcaption class="px-4 py-3 text-sm text-slate-600 bg-slate-50">
                                            Passage en mode modification de la section performances.
                                        </figcaption>
                                    </figure>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-lg border border-amber-200 bg-amber-50 p-4">
                            <p class="text-sm font-semibold text-amber-900">Points d’attention</p>
                            <ul class="mt-2 list-disc list-inside space-y-1 text-sm text-amber-800">
                                <li>Vérifier l’orthographe du nom de l’artiste avant sauvegarde.</li>
                                <li>Contrôler que les informations publiques sont complètes et cohérentes.</li>
                                <li>Valider les performances liées pour éviter les incohérences de programmation.</li>
                            </ul>
                        </div>
                    </div>
                </article>

                <article id="section3-3" class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
                        <p class="text-xs uppercase tracking-widest text-slate-500">Partie III.3</p>
                        <h3 class="text-xl md:text-2xl font-bold text-slate-900">Gestion des stands</h3>
                    </div>
                    <div class="p-6 space-y-8">
                        <p class="text-slate-700 leading-relaxed">
                            Cette section sera prochainement développée pour expliquer le parcours complet de gestion des
                            stands.
                        </p>
                    </div>
                </article>

                <article id="section3-4" class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
                        <p class="text-xs uppercase tracking-widest text-slate-500">Partie III.4</p>
                        <h3 class="text-xl md:text-2xl font-bold text-slate-900">Gestion des utilisateurs</h3>
                    </div>
                    <div class="p-6 space-y-8">
                        <p class="text-slate-700 leading-relaxed">
                            Cette section sera prochainement développée pour expliquer le parcours complet de gestion des
                            utilisateurs.
                        </p>
                    </div>
                </article>

                <article id="section3-5" class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
                        <p class="text-xs uppercase tracking-widest text-slate-500">Partie III.5</p>
                        <h3 class="text-xl md:text-2xl font-bold text-slate-900">Gestion des FAQs</h3>
                    </div>
                    <div class="p-6 space-y-8">
                        <p class="text-slate-700 leading-relaxed">
                            Cette section sera prochainement développée pour expliquer le parcours complet de gestion des
                            FAQs.
                        </p>
                    </div>
                </article>

                <article id="section4" class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="px-6 py-4 rounded-t-lg"
                        style="background: linear-gradient(90deg, #9333ea 0%, #ec4899 100%);">
                        <p class="text-xs uppercase tracking-widest text-white/80">Partie IV</p>
                        <h2 class="text-2xl md:text-3xl font-bold text-white">Calan'Boutique</h2>
                    </div>
                    <div class="p-6">
                        <p class="text-slate-700 leading-relaxed">
                            La Calan'Boutique est la plateforme de vente en ligne des produits dérivés du festival. Elle
                            permet aux visiteurs d'acheter des articles officiels et de soutenir l'association. Cette
                            section arrive prochainement.
                        </p>
                    </div>
                </article>
            </section>
        </div>

        <div id="doc-lightbox" class="fixed inset-0 z-[9999] hidden items-center justify-center bg-black/80 p-4"
            role="dialog" aria-modal="true" aria-label="Aperçu image">
            <button id="doc-lightbox-close" type="button"
                class="absolute top-4 right-4 text-white text-3xl leading-none hover:text-red-300" aria-label="Fermer">
                &times;
            </button>

            <img id="doc-lightbox-image" src="" alt=""
                class="max-h-[90vh] max-w-[95vw] rounded-lg shadow-2xl object-contain">
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Navigation du sommaire (inchangé)
            document.querySelectorAll('.doc-link').forEach(function(button) {
                button.addEventListener('click', function() {
                    const targetId = button.getAttribute('data-target');
                    const targetElement = document.getElementById(targetId);
                    const container = document.getElementById('doc-content');

                    if (!targetElement || !container) return;

                    const topPos = targetElement.offsetTop - container.offsetTop;
                    container.scrollTo({
                        top: topPos,
                        behavior: 'smooth'
                    });
                });
            });

            // Lightbox
            const lightbox = document.getElementById('doc-lightbox');
            const lightboxImage = document.getElementById('doc-lightbox-image');
            const closeBtn = document.getElementById('doc-lightbox-close');

            if (!lightbox || !lightboxImage || !closeBtn) return;

            document.querySelectorAll('.doc-zoomable').forEach(function(img) {
                img.addEventListener('click', function() {
                    lightboxImage.src = img.src;
                    lightboxImage.alt = img.alt || 'Image agrandie';
                    lightbox.classList.remove('hidden');
                    lightbox.classList.add('flex');
                });
            });

            function closeLightbox() {
                lightbox.classList.add('hidden');
                lightbox.classList.remove('flex');
                lightboxImage.src = '';
            }

            closeBtn.addEventListener('click', closeLightbox);

            lightbox.addEventListener('click', function(e) {
                if (e.target === lightbox) closeLightbox(); // clic fond noir
            });

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !lightbox.classList.contains('hidden')) {
                    closeLightbox();
                }
            });
        });
    </script>
@endsection
