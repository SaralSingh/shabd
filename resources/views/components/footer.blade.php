<style>
/* --- Footer --- */
.footer {
    border-top: 1px solid var(--border-line);
    padding: 2rem 3rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.85rem;
    color: var(--ink-secondary);
}
@media (max-width: 900px) {
    .footer { flex-direction: column; gap: 1rem; }
}
</style>

<footer class="footer">
    <div>© {{ date('Y') }} Shabd Platform.</div>
    <div>Designed for Writers.</div>
</footer>
