# CLAUDE.md
# Customizer-Core Development Standards (Laravel + JS/Vue)

## Objective

Generate production-ready api (Laravel) and frontend (Vue/JS) code for a new project or prototype, based on the conventions already established in the customizer-core codebase.

The generated output should require minimal manual cleanup and be ready for implementation.

---

# Technology Stack

Use only the following unless otherwise specified.

API:
- PHP 8.3
- Laravel 13
- Inertia (server adapter)
- Laravel Passport / Sanctum

Frontend:
- Vue 3 (Composition API, TypeScript)
- Inertia.js
- Pinia
- TypeScript — required for every new Vue component's `<script>` block, plus the engine/core layer and utilities

Do NOT use:

- Vuex or any other state library besides Pinia
- A plain `<script setup>` (no `lang="ts"`) on a new Vue component
- A second HTTP client (use `@/api/http.ts` / `api/*.js`)
- A second utility/date library beyond `underscore`/`lodash` already in use
- A linter config change as a drive-by of an unrelated task

---

# Laravel / API Standards

Namespace controllers by purpose, not by resource.

Preferred elements:

- `Http/Controllers/Api/` — JSON API endpoints
- `Http/Controllers/Pages/` — Inertia page controllers
- `Http/Controllers/Auth/` — auth scaffolding
- `Http/Controllers/Action/` — one-off action endpoints
- `Http/Controllers/Traits/` — shared controller behavior

Requirements:

- Controllers stay thin: fetch → authorize → delegate → respond
- Authorize with `Gate::inspect("ability", $model)`, backed by a `Policy` per model
- Respond through the `ApiResponse` trait (`successResponse`, `successWithDataResponse`, `errorResponse`, `abort`) — never hand-roll `response()->json()`
- Route-model-bind the primary resource in the method signature
- User-facing strings go through `__("messages.*", [...])` translation keys, not hardcoded text
- Log state changes and failures with `Log::info`/`Log::error`, including relevant IDs

---

# Validation Standards

- Use a `FormRequest` class (`Http/Requests/`) for any endpoint with more than 1–2 rules, or validation reused across methods
- Inline `Validator::make($input, [...])` is acceptable only for a single simple rule
- Never leave a `FormRequest::rules()` stubbed empty once the endpoint is real
- Never skip authorization on a mutating endpoint

---

# Model Standards

Fat models are the convention. Entity-owned business logic lives on the model, not in a controller or a generic helper.

Requirements:

- `$fillable`, `$hidden`, `$casts` declared at the top, grouped logically
- Enum-like values as class constants, `SCREAMING_SNAKE_CASE`, referenced via `static::CONST_NAME`
- Query scopes as `scopeXxx($query, ...)`
- Derived values as plain public methods (`isComplete()`), not accessors, unless needed in serialization
- Static factory/lookup helpers for cross-model creation (`Cart::createCart($user, $data)`)

Extract to `app/Services/` only when logic:

- Spans multiple models/domains
- Needs its own inputs/configuration independent of a single model
- Is a distinct calculation with a single clear entry point

Never invent a Service for logic that really belongs to one model.

---

# API & Resource Standards

- One `Resources/` transformer per model for generic API output
- Integration-specific payload shaping goes in its own subfolder, named after that integration (e.g. `Resources/NexioPayload/`)
- Never mix integration-specific field mapping into the general-purpose resource
- All JSON responses use the shape: `{ success, status_code, message, data }`
- Never introduce a second response envelope shape

---

# Async & Domain Events

- Slow or externally-dependent work (PDF/thumbnail generation, pricing sync) is a queued `Job`, dispatched with IDs, not full models
- State changes other parts of the system react to are `Event` + `Listener` pairs
- Prefer firing an `Event` over calling a side-effect directly when more than one listener could plausibly care

---

# Multi-Brand / White-Label Standards

This application serves multiple brands from one codebase.

- Gate brand-specific behavior behind `config('brand.*')` flags/IDs — never hostnames or env checks inline
- Never hardcode a brand color, name, or ID directly in business logic
- Global cross-cutting helpers belong in `app/helpers.php` only when used across unrelated models/controllers

---

# Vue Component Standards

Create reusable components whenever possible, grouped by feature/domain folder.

Examples:

- Modals
- Forms
- Tables
- Tooltips
- Navigation

Requirements:

- `<script setup lang="ts">` Composition API for every new component — TypeScript is required, not optional
- Type props with `defineProps<{ ... }>()` (a generic type or interface), not the runtime options object; same for `defineEmits<{ ... }>()`
- `defineExpose` for methods a parent needs to call imperatively, typed the same way
- Shared services (notifications, modal handoff) via `inject`/`provide`, typed with `inject<T>('key')`, not singleton imports
- A template-only `.vue` file (no script block) is fine for static markup — don't add an empty script block for its own sake

---

# Naming Convention

| Layer | Convention | Example |
|---|---|---|
| PHP classes | PascalCase, role-suffixed | `CartController`, `GeneratePDFJob` |
| PHP constants | SCREAMING_SNAKE_CASE | `STATUS_ACTIVE` |
| Vue components/pages | PascalCase.vue | `ApplicationSize.vue` |
| Composables | useXxx.ts | `useEmailAccountLookup.ts` |
| Pinia stores | kebab-case file, `useXStore` export | `cart-items.js` → `useCartItemStore` |
| API modules | kebab-case, one per resource | `discount-code.js` |
| JS variables/functions | camelCase | `fetchCartsMinimized` |

Avoid autogenerated class names. Avoid random IDs. Use meaningful names.

---

# API Architecture

Keep responsibilities modular. Separate:

- Controllers (thin, purpose-namespaced)
- Models (entity-owned logic)
- Services (cross-entity logic)
- Policies (authorization)
- Jobs / Events / Listeners (async work & domain reactions)

Use `app/Modules/{Name}/` for a large, semi-independent feature area with its own models/routes/migrations (see `Integration`, `TeamDatabase`). Do not use it for a handful of related endpoints — that's a normal `Controllers/` subfolder.

---

# Frontend Architecture

Keep responsibilities modular. Separate:

- `Components/` — presentation, grouped by feature
- `Pages/` — one Inertia page per route
- `Composables/` — reusable stateful logic, `useXxx`
- `stores/` — Pinia, one per domain, thin actions
- `api/` — one file per backend resource, plain async functions
- `core/` — framework-agnostic domain/engine logic (TypeScript)

New customizer logic belongs in `core/customizer/*.ts`, never in `stores/customizer.js` (already ~12k lines) or directly in a component.

Always import via the `@/...` path aliases (`jsconfig.json`). Never use long relative import chains.

---

# JavaScript / Vue Standards

Keep JavaScript modular and out of templates beyond `<script setup lang="ts">`.

- Composition API (`<script setup lang="ts">`) for every new component — required per team standard, not left to individual preference
- Composables (`useXxx.ts`) for reusable stateful logic — one concern per composable, typed inputs/return value
- Pinia stores: options-style `defineStore`, `getters(state)`, actions delegate network calls to `api/*.js`
- `api/*.js`: plain async functions, always check `response.success`, catch and log errors at this layer
- TypeScript is required for all new Vue components and composables, plus `core/**` engine logic and utilities. Pinia stores and the `api/*.js` layer remain incrementally adopted — don't convert an existing `.js` file to `.ts` as a side effect of an unrelated change; do it as its own deliberate step

---

# Output Requirements

The generated code must:

✓ Namespace controllers by purpose, not sit at the `Controllers/` root
✓ Authorize via `Gate::inspect()` + Policy, and respond via the `ApiResponse` trait
✓ Put entity-owned logic on the model; put cross-entity logic in a Service
✓ Use a `FormRequest` for any non-trivial validation
✓ Gate brand-specific behavior behind `config('brand.*')`
✓ Use `<script setup lang="ts">` for every new Vue component, with typed `defineProps`/`defineEmits`
✓ Import via `@/...` aliases, never long relative paths
✓ Put new customizer logic in `core/customizer/*.ts`
✓ Keep Pinia store actions thin
✓ Check `response.success` on every API call
✓ Be maintainable, scalable, and production-ready

---

# Important

Always generate code that follows these standards unless explicitly instructed otherwise.

Match the surrounding file's existing pattern first. Where this document and a specific file disagree, prefer consistency with the immediately neighboring code, then flag the inconsistency rather than silently picking a convention for a single new file.

Do not prioritize speed over code quality. Consistency, maintainability, and scalability are the primary goals.
