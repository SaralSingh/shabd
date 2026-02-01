@if(session('auth_token'))
<script>
    localStorage.setItem('token', "{{ session('auth_token') }}");
</script>
@endif
