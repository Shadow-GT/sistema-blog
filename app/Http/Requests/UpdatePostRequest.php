<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $post = $this->route()->parameter('post');
        return auth()->check() &&
               (auth()->user()->canModerate() ||
                (auth()->user()->canPublish() && $post && $post->user_id === auth()->id()));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $postId = $this->route()->parameter('post')->id ?? null;

        $rules = [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:posts,slug,' . $postId,
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,pending,published,rejected',
            'category_id' => 'required|exists:categories,id',
            'post_type_id' => 'required|exists:post_types,id',
            'meta_data' => 'nullable|array',
            'published_at' => 'nullable|date',
        ];

        // Solo los administradores pueden establecer posts como destacados
        if (auth()->user()->canModerate()) {
            $rules['is_featured'] = 'boolean';
        }

        return $rules;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        // Si el usuario no es admin, preservar el valor actual de is_featured
        if (!auth()->user()->canModerate()) {
            $post = $this->route()->parameter('post');
            $this->merge([
                'is_featured' => $post ? $post->is_featured : false,
            ]);
        }
    }
}
