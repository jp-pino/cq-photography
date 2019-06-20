function replaceHtml( string_to_replace ) {
    return string_to_replace.replace(/&nbsp;/g, ' ').replace(/<br.*?>/g, '\n');
}
