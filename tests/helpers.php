<?php
function refreshDatabase()
{
    // Drop all tables
    Capsule::schema()->dropAllTables();

    // Recreate tables
    require __DIR__ . '/migrations/create_tables.php';
}
