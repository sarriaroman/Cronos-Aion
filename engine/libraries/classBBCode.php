<?php
class bbcode {
  /*
    types of tags:

    s - single: standalone tags like [time]
    d - double: open/close tags like [b]bold[/b]
    t - triple: open/close with variable tags like [url:http://mysite.com]mysite.com[/url]
    f - flag: like [pl] or [de]
  */
  function bbcode ($usebb) {
    if ($usebb == 0) {
      return;
    }
    //pre-defined tags
    $this->tag->s->br = 'br';
    $this->tag->s->img = 'img';

    $this->tag->d->b = 'strong';
    $this->tag->d->i = 'em';
    $this->tag->d->u = 'u';
    $this->tag->d->quote = 'blockquote';
    $this->tag->d->code = 'code';

    $this->tag->t->url = 'a||target="blank"';
    $this->tag->t->link = $this->tag->t->url;
  }

  function addTag ($type, $tag, $html, $variables=null) {
    if ($type == 't' && !$regexpin) {
      return false;
    }
    if ($type == 's') {
      $this->tag->$type->$tag = $html;
    } else if ($type == 'd') {
      $this->tag->$type->$tag = $html;
    } else if ($type == 't') {
      $this->tag->$type->$tag = $html.'|| '.$variables;
    } else if ($type == 'f') {
      $this->tag->$type->$tag = '';
    } else {
      return false;
    }
  }

  function delTag ($type=null,$tag=null) {
    if ($this->tag->$type->$tag) {
      unset($this->tag->$type->$tag);
    } else {
      return false;
    }
  }

  function parse ($text) {
    if (count($this->tag->f) > 0) {
      foreach ($this->tag->f as $flag => $country) {
        $text = preg_replace('#\['.$flag.'\]#si', '[img:src="img/flags/'.$flag.'.gif" alt="'.$country.'"]', $text);
      }
    }

    if (count($this->tag->s) > 0) {
      foreach ($this->tag->s as $tag => $html) {
        $text = preg_replace('#\['.$tag.'(:(.+))?\]#si', '<'.$html.' \\2/>', $text);
      }
    }

    if (count($this->tag->d) > 0) {
      foreach ($this->tag->d as $tag => $html) {
        $text = preg_replace('#\['.$tag.'\](.+)\[/'.$tag.'\]#si', '<'.$html.'>\\1</'.$html.'>', $text);
      }
    }

    if (count($this->tag->t) > 0) {
      foreach ($this->tag->t as $tag => $replacement) {
        list($html, $args) = explode('||', $replacement);
        $text = preg_replace('#\['.$tag.':(.+)\](.+)\[/'.$tag.'\]#si', '<'.$html.' '.$args.' \\1>\\2</'.$html.'>', $text);
      }
    }
    return $text;
  }
}
?>