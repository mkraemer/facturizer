#Facturizer

A small terminal application to help tracking time spent for project-related activities and creating invoices for these activities.

## Use-Case

Facturizer is built around my requirements for a basic time tracking and invoicing tool using the command line.
Those requirements include:

* I am working for multiple clients
* I am working for one or multiple projects for each client
* Every project can be divided in activities
* The invoices I create are listing these activities

If your requirements are similar, you could give Facturizer a shot :)

The creation of the invoices is done using a client-specific invoice template (using twig) which is filled with the invoice posts. This process provides great flexibility and allows for example the creation of PDF invoices by using a LaTeX template.

Managing client or currency information is outside the scope of Facturizer.
Of course the generated invoices should include these information, but as they are pretty static for a given client, they are included in the client-specific invoice template.

## Configuration

### Facturizer setup

Facturizer expects to find a config.yml in the directory ~/.facturizer/
The file should have the following structure:

    parameters:
        template_path: ~/.facturizer/templates
        storage_path: ~/.facturizer

The template path should point at a directory where you want to keep your client-specific invoice templates.
The storage path should point to a directory, where the generated data will be saved.

### Invoice templates

I personally use LaTeX for creating invoices, but for the sake of simplicity, we'll assumene that we want to generate markdown invoices:

demo_client.md.twig:


    # Invoice #{{invoice.serial}}

    ## Posts
    I invoice the following things:

    {%for post in invoice.posts%}
    {{post.projectName}} - {{post.activityName}} - {{post.amount}} - ${{post.rate}} - ${{post.total}}
    {%endfor%}

    That makes a total of ${{invoice.total}}

As you can see, at the invoice template, we've got an invoice object with the following properties we can use:

* invoice
    * posts
        * projectName
        * activityName
        * amount
        * rate
        * total
    * total

## Usage

Facturizer exposes a simple command line interface.
To get a list of available commands, run
facturizer.php help

In the following examples, I've got f aliased to facturizer.php

### Create clients

Clients are created using the 'cc' command.
It works using the following scheme:

    f cc client-name hourly-rate template-name

Note that Facturizer is working currency-agnostic at this point.

So for our example, we'll use

    f cc 'Demo client' 70 invoice_template.tex.twig


This is the first client created, so Facturizer will respond with the information that the client was assigned with the handle 1.
We'll use this handle when referencing this client in the next step.

### Create projects

Creating a project for a client is being done with the 'pc' command using the following syntax:

    f pc client-handle project-name

For our example, we'll do:

    f pc 1 'Demo project'

### Create activities

    f ac 1 'Read documentation' --estimation 1

### Lising activities

    f

### Book time spent to activity

    f ab 1 2

Because this is the mose used command, this is the default command, which means, 'ab' can be left out. So to add the two hours spent to activity one, you can use

    f 1 2

### Create invoice for clients

    f invoice client-handle invoice-id

The invoice-id you use here will be passed to the invoice template.
