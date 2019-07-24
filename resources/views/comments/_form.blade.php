@auth
  <comment-form
      :post-id="{{ $post->id }}"
      placeholder="@lang('comments.placeholder.content')"
      button="@lang('comments.comment')">
  </comment-form>
@else
  @component('components.alerts.default', ['type' => 'warning'])
    @lang('comments.sign_in_to_comment')
  @endcomponent
@endauth
