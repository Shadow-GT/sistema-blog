@props([
    'post',
])
<article {{ $attributes->merge(['class' => 'group flex flex-col overflow-hidden rounded-3xl bg-white shadow-soft ring-1 ring-secondary-100 transition-all duration-300 hover:-translate-y-1 hover:shadow-large']) }}>
    <a href="{{ route('blog.show', $post->slug) }}" class="relative block aspect-[16/9] overflow-hidden">
        @if($post->featured_image)
            <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}"
                 class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy">
        @else
            <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-primary-400 via-primary-500 to-accent-500">
                <span class="text-4xl opacity-90">{{ $post->postType->icon ?? '📄' }}</span>
            </div>
        @endif

        @if($post->is_featured)
            <span class="absolute left-4 top-4 inline-flex items-center gap-1 rounded-full bg-white/90 px-2.5 py-0.5 text-xs font-semibold text-primary-700 shadow-sm backdrop-blur">
                <x-lucide-star class="h-3.5 w-3.5 fill-current" /> Destacado
            </span>
        @endif
    </a>

    <div class="flex flex-1 flex-col p-6">
        <div class="mb-3 flex flex-wrap items-center gap-2">
            @if($post->category)
                <x-category-badge :category="$post->category" />
            @endif
            @if($post->postType)
                <span class="inline-flex items-center gap-1 text-xs font-medium text-secondary-500">
                    <span>{{ $post->postType->icon }}</span>{{ $post->postType->name }}
                </span>
            @endif
        </div>

        <h3 class="mb-2 text-lg font-bold leading-snug text-secondary-900 line-clamp-2 transition-colors group-hover:text-primary-700">
            <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
        </h3>

        <p class="mb-4 flex-1 text-sm leading-relaxed text-secondary-600 line-clamp-3">{{ $post->excerpt }}</p>

        <div class="mt-auto flex items-center justify-between border-t border-secondary-100 pt-4 text-xs text-secondary-500">
            <div class="flex items-center gap-2">
                <x-avatar :name="$post->user->name ?? '?'" size="xs" />
                <span class="font-medium text-secondary-700">{{ $post->user->name ?? 'Anónimo' }}</span>
            </div>
            <div class="flex items-center gap-3">
                @if($post->published_at)
                    <span class="inline-flex items-center gap-1">
                        <x-lucide-calendar class="h-3.5 w-3.5" />{{ $post->published_at->format('d M Y') }}
                    </span>
                @endif
                <span class="inline-flex items-center gap-1">
                    <x-lucide-eye class="h-3.5 w-3.5" />{{ $post->views_count }}
                </span>
            </div>
        </div>
    </div>
</article>
